<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

class PurchaseReturn extends Model
{
    use SoftDeletes;
    protected $table = 'purchase_returns';
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
    			return 'Đã trả hàng';
    			break;
    		case self::CANCEL :
    			return 'Đã hủy';
    			break;
    		default:
    			return 'Không xác định';
    			break;
    	}
    }

    public function getBranchName(){
    	if($this->branch_id == 0)
    		return 'Chi nhánh trung tâm';

    	$branch = \App\Branch::find($this->branch_id);
    	return ($branch == null) ? '' : $branch->name;
    }

    public function getSupplierName(){
    	if(is_null($this->supplier_id))
    		return 'Không được khai báo';

    	$supplier = \App\Supplier::find($this->supplier_id);
    	return ($supplier == null) ? '' : $supplier->name;
    }

    public function getCreator(){
        $creator = \App\User::find($this->user_id);
        return ($creator == null) ? '' : !empty($creator->name) ? $creator->name : $creator->nickname;
    }

    public function getCommodities(){
        $purchaseReturnCommodities = \App\PurchaseReturnCommodity::where(['purchase_return_id' => $this->id])->get();
        return $purchaseReturnCommodities;
    }

    public static function savePurchaseReturn($params){
    	if(!isset($params['Commodity'])){
    		return false;
    	}

    	$purchaseReturn = new self;
    	$purchaseReturn->code = 'auto';
    	$purchaseReturn->return_date = ($params['purchaseReturn']['return_date'] != '') ? $params['purchaseReturn']['return_date'] : date('Y-m-d H:i:s');
    	$purchaseReturn->company_id = \Auth::user()->company_id;
    	$purchaseReturn->supplier_id = ($params['purchaseReturn']['supplier_id'] != '') ? $params['purchaseReturn']['supplier_id'] : null;
    	$purchaseReturn->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
    	$purchaseReturn->user_id = ($params['purchaseReturn']['user_id'] != '') ? $params['purchaseReturn']['user_id'] : \Auth::user()->id;
    	$purchaseReturn->note = $params['purchaseReturn']['note'];
    	$purchaseReturn->quantum = count($params['Commodity']);
    	$purchaseReturn->amount_money = $params['purchaseReturn']['amount_money'];
    	$purchaseReturn->total_money = $params['purchaseReturn']['total_money'];
    	$purchaseReturn->payed_money = $params['purchaseReturn']['payed_money'];
    	$purchaseReturn->sale_type = 0;
    	$purchaseReturn->status = self::DONE;

    	\DB::beginTransaction();
        try {
            $purchaseReturn->save();
        	$purchaseReturn->code = 'TNH' . $purchaseReturn->id;
        	$purchaseReturn->save();
        	foreach ($params['Commodity'] as $commodity_id => $data) {
        		$purchaseReturnCommodity = new \App\PurchaseReturnCommodity;
        		$purchaseReturnCommodity->purchase_return_id = $purchaseReturn->id;
        		$purchaseReturnCommodity->commodity_id = $commodity_id;
        		$purchaseReturnCommodity->company_id = $purchaseReturn->company_id;
        		$purchaseReturnCommodity->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        		$purchaseReturnCommodity->cost_price = $data['cost_price'];
        		$purchaseReturnCommodity->return_price = $data['return_price'];
        		$purchaseReturnCommodity->quantum = $data['number'];
        		$purchaseReturnCommodity->save();

                # update on hand for commodity
                $num_on_hand = (0-$purchaseReturnCommodity->quantum);
        		\App\BranchCommodity::updateOnHand($commodity_id,$num_on_hand);
        	}
            \DB::commit();
        	return true;
        } catch (\Exception $e) {
            \DB::rollback();
            return false;
        }
    }

    public static function searchPurchaseReturns($input,$paginate=true){
        $purchasereturns = [];
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $queries =  self::select('purchase_returns.*')
                    ->leftJoin('suppliers', 'purchase_returns.supplier_id', '=', 'suppliers.id')
                    ->leftJoin('purchase_return_commodities', 'purchase_returns.id', '=', 'purchase_return_commodities.purchase_return_id')
                    ->leftJoin('commodities', 'purchase_return_commodities.commodity_id', '=', 'commodities.id');

        $queries->whereNull('purchase_returns.deleted_at')->where(['purchase_returns.company_id'=>\Auth::user()->company_id, 'purchase_returns.branch_id' =>$branch_id]);

        if($input::get('code') != null){
            $queries->where('purchase_returns.code', 'like', "{$input::get('code')}%");
        }

        if($input::get('pcode') != null){
            $queries->where(function ($query) {
                $input = new Input;
                $query->orWhere('commodities.code', 'like', "{$input::get('pcode')}%")
                      ->orWhere('commodities.name', 'like', "{$input::get('pcode')}%");
            });
        }

        if($input::get('note') != null){
            $queries->where('purchase_returns.note', 'like', "{$input::get('note')}%");
        }

        if($input::get('uname') != null){
            $queries->where('purchase_returns.user_id', '=', $input::get('uname'));
        }

        if($input::get('status') != -1){
            $queries->where('purchase_returns.status', '=', $input::get('status'));
        }

        if($input::get('sdate') != null){
            $queries->where('purchase_returns.return_date', '>=', $input::get('sdate'));
        }

        if($input::get('edate') != null){
            $queries->where('purchase_returns.return_date', '<=', $input::get('edate'));
        }

        if($input::get('scode') != null){
            $queries->where(function ($query) {
                $input = new Input;
                $query->orWhere('suppliers.code', 'like', "{$input::get('scode')}%")
                      ->orWhere('suppliers.name', 'like', "{$input::get('scode')}%");
            });
        }

        if($paginate){
            $purchasereturns = $queries->groupBy('purchase_returns.id')->orderBy('purchase_returns.created_at', 'DESC')->paginate(10);
        }else{
            $purchasereturns = $queries->groupBy('purchase_returns.id')->orderBy('purchase_returns.created_at', 'DESC')->get();
        }
        

        return $purchasereturns;
    }
}
