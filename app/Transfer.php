<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

class Transfer extends Model
{
    use SoftDeletes;
	protected $table = 'transfers';
    protected $dates = ['deleted_at'];

    CONST TEMP 		= 0;
    CONST DONE 		= 1;
    CONST CANCEL 	= 2;

    public function getStatus(){
    	switch ($this->status) {
    		case self::TEMP :
    			return 'Phiếu tạm';
    			break;
    		case self::DONE :
    			return 'Đã nhận';
    			break;
    		case self::CANCEL :
    			return 'Đã hủy';
    			break;
    		default:
    			return 'Không xác định';
    			break;
    	}
    }

    public function getFromBranchName(){
    	if($this->from_branch_id == 0)
    		return 'Chi nhánh trung tâm';

    	$branch = \App\Branch::find($this->from_branch_id);
    	return ($branch == null) ? '' : $branch->name;
    }

    public function getToBranchName(){
    	if($this->to_branch_id == 0)
    		return 'Chi nhánh trung tâm';

    	$branch = \App\Branch::find($this->to_branch_id);
    	return ($branch == null) ? '' : $branch->name;
    }

    public function getCreator(){
        $creator = \App\User::find($this->user_id);
        return ($creator == null) ? '' : !empty($creator->name) ? $creator->name : $creator->nickname;
    }

    public function getCommodities(){
        $transferCommodities = \App\TransferCommodity::where(['transfer_order_id' => $this->id])->get();
        return $transferCommodities;
    }

    public static function saveTransfer($params){
    	if(!isset($params['Commodity'])){
    		return false;
    	}

    	$transfer = new self;
    	$transfer->code = 'auto';
    	$transfer->transfer_date = ($params['transfer']['transfer_date'] != '') ? $params['transfer']['transfer_date'] : date('Y-m-d H:i:s');
    	$transfer->company_id = \Auth::user()->company_id;
    	$transfer->from_branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
    	$transfer->to_branch_id = $params['transfer']['to_branch_id'];
    	$transfer->user_id = ($params['transfer']['user_id'] != '') ? $params['transfer']['user_id'] : \Auth::user()->id;
    	$transfer->note = $params['transfer']['note'];
    	$transfer->quantum = count($params['transfer']['quantum']);
    	$transfer->total_money = $params['transfer']['total_money'];
    	$transfer->status = self::DONE;

    	\DB::beginTransaction();
        try {
            $transfer->save();
        	$transfer->code = 'TRF' . $transfer->id;
        	$transfer->save();
        	foreach ($params['Commodity'] as $commodity_id => $data) {
        		$transferCommodity = new \App\TransferCommodity;
        		$transferCommodity->transfer_order_id = $transfer->id;
        		$transferCommodity->commodity_id = $commodity_id;
        		$transferCommodity->company_id = $transfer->company_id;
        		$transferCommodity->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        		$transferCommodity->base_price = $data['cost_price'];
        		$transferCommodity->quantum = $data['number'];
        		$transferCommodity->transfer_money = $data['transfer_price'];
        		$transferCommodity->save();

                # update on hand for commodity
                \App\BranchCommodity::updateOnHand($commodity_id,$transferCommodity->quantum,false,$transfer->to_branch_id);
        		\App\BranchCommodity::updateOnHand($commodity_id,(0-$transferCommodity->quantum),false,$transfer->from_branch_id);
        	}
            \DB::commit();
        	return true;
        } catch (\Exception $e) {
            \DB::rollback();
            return false;
        }
    }

    public static function searchTransfers($input,$paginate=true){
        $transfers = [];
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $queries =  Transfer::select('transfers.*')
                    ->leftJoin('transfer_commodities', 'transfers.id', '=', 'transfer_commodities.transfer_order_id')
                    ->leftJoin('commodities', 'transfer_commodities.commodity_id', '=', 'commodities.id');

        $queries->whereNull('transfers.deleted_at')->where(['transfers.company_id'=>\Auth::user()->company_id ]);

        if($input::get('code') != null){
            $queries->where('transfers.code', 'like', "{$input::get('code')}%");
        }

        if($input::get('pcode') != null){
            $queries->where(function ($query) use ($input){
                $query->orWhere('commodities.code', 'like', "{$input::get('pcode')}%")
                      ->orWhere('commodities.name', 'like', "{$input::get('pcode')}%");
            });
        }

        if($input::get('note') != null){
            $queries->where('transfers.note', 'like', "{$input::get('note')}%");
        }

        if($input::get('uname') != null){
            $queries->where('transfers.user_id', '=', $input::get('uname'));
        }

        if($input::get('status') != -1){
            $queries->where('transfers.status', '=', $input::get('status'));
        }

        if($input::get('sdate') != null){
            $queries->where('transfers.transfer_date', '>=', $input::get('sdate'));
        }

        if($input::get('edate') != null){
            $queries->where('transfers.transfer_date', '<=', $input::get('edate'));
        }

        if($input::get('type') != null && $input::get('type') != -1){
        	if($input::get('type')==1){
            	$queries->where('transfers.from_branch_id', '=', $branch_id);
        	}else{
        		$queries->where('transfers.to_branch_id', '=', $branch_id);
        	}
        }else{
        	$queries->where(function ($query) use ($branch_id) {
	            $query->orWhere('transfers.from_branch_id', '=', $branch_id)
	                  ->orWhere('transfers.to_branch_id', '=', $branch_id);
	        });
        }

        if($paginate){
            $transfers = $queries->groupBy('transfers.id')->orderBy('transfers.created_at', 'DESC')->paginate(10);
        }else{
            $transfers = $queries->groupBy('transfers.id')->orderBy('transfers.created_at', 'DESC')->get();
        }

        return $transfers;
    }
}
