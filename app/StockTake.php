<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTake extends Model
{
	CONST TEMP 		= 0;
    CONST DONE      = 1;
    CONST CANCEL 	= 2;
    
    protected $table = 'stock_takes';

    public function getStatus(){
    	switch ($this->status) {
    		case self::TEMP :
    			return 'Phiếu tạm';
    			break;
    		case self::DONE :
    			return 'Đã cân bằng kho';
    			break;
    		case self::CANCEL :
    			return 'Đã hủy';
    			break;
    		default:
    			return 'Không xác định';
    			break;
    	}
    }

    public function getCreator(){
        $creator = \App\User::find($this->user_id);
        return ($creator == null) ? '' : !empty($creator->name) ? $creator->name : $creator->nickname;
    }

    public function getCommodities(){
        $stockTakeCommodities = \App\StockTakeCommodity::where(['stock_take_id' => $this->id])->get();
        return $stockTakeCommodities;
    }

    public static function searchStockTakes($input,$paginate=true){
        $datas = [];
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $queries =  self::select('stock_takes.*')
                    ->leftJoin('stock_take_commodities', 'stock_takes.id', '=', 'stock_take_commodities.stock_take_id')
                    ->leftJoin('commodities', 'stock_take_commodities.commodity_id', '=', 'commodities.id');

        $queries->whereNull('stock_takes.deleted_at')->where(['stock_takes.company_id'=>\Auth::user()->company_id, 'stock_takes.branch_id' => $branch_id]);

        if($input::get('code') != null){
            $queries->where('stock_takes.code', 'like', "{$input::get('code')}%");
        }

        if($input::get('pcode') != null){
            $queries->where(function ($query) use ($input) {
                $query->orWhere('commodities.code', 'like', "{$input::get('pcode')}%")
                      ->orWhere('commodities.name', 'like', "{$input::get('pcode')}%");
            });
        }

        if($input::get('note') != null){
            $queries->where('stock_takes.note', 'like', "{$input::get('note')}%");
        }

        if($input::get('uname') != null){
            $queries->where('stock_takes.user_id', '=', $input::get('uname'));
        }

        if($input::get('status') != -1){
            $queries->where('stock_takes.status', '=', $input::get('status'));
        }

        if($input::get('sdate') != null){
            $queries->where('stock_takes.created_at', '>=', $input::get('sdate'));
        }

        if($input::get('edate') != null){
            $queries->where('stock_takes.created_at', '<=', $input::get('edate'));
        }

        if($paginate){
            $datas = $queries->groupBy('stock_takes.id')->orderBy('stock_takes.created_at', 'DESC')->paginate(10);
        }else{
            $datas = $queries->groupBy('stock_takes.id')->orderBy('stock_takes.created_at', 'DESC')->get();
        }
        

        return $datas;
    }

    public static function saveStockTake($params){
    	if(!isset($params['Commodity'])){
    		return false;
    	}

    	$stockTake = new self;
    	$stockTake->code = 'auto';
    	$stockTake->balance_date = ($params['stockTake']['balance_date'] != '') ? $params['stockTake']['balance_date'] : date('Y-m-d H:i:s');
    	$stockTake->company_id = \Auth::user()->company_id;
    	$stockTake->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
    	$stockTake->user_id = ($params['stockTake']['user_id'] != '') ? $params['stockTake']['user_id'] : \Auth::user()->id;
    	$stockTake->balancer_id = ($params['stockTake']['user_id'] != '') ? $params['stockTake']['user_id'] : \Auth::user()->id;
    	$stockTake->note = $params['stockTake']['note'];
    	$stockTake->quantum = $params['stockTake']['quantum'];
    	$stockTake->quantum_diff = $params['stockTake']['quantum_diff'];
    	$stockTake->status = self::DONE;

    	\DB::beginTransaction();
        try {
        	$stockTake->save();
        	$stockTake->code = 'KK' . $stockTake->id;
        	$stockTake->save();
        	foreach ($params['Commodity'] as $commodity_id => $data) {
        		$stockTakeCommodity = new \App\StockTakeCommodity;
        		$stockTakeCommodity->stock_take_id = $stockTake->id;
        		$stockTakeCommodity->commodity_id = $commodity_id;
        		$stockTakeCommodity->company_id = $stockTake->company_id;
        		$stockTakeCommodity->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        		$stockTakeCommodity->on_hand = $data['on_hand'];
        		$stockTakeCommodity->quantum = $data['quantum'];
        		$stockTakeCommodity->quantum_diff = $data['quantum_diff'];
        		$stockTakeCommodity->save();

                # update on hand for commodity
        		\App\BranchCommodity::updateOnHand($commodity_id,$stockTakeCommodity->quantum,true);
        	}
            \DB::commit();
        	return true;
        } catch (\Exception $e) {
            \DB::rollback();
            return false;
        }
    }
}
