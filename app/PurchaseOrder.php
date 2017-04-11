<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

class PurchaseOrder extends Model
{
	use SoftDeletes;
	protected $table = 'purchase_orders';
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
    			return 'Đã nhập hàng';
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
        $purchaseOrderCommodities = \App\PurchaseOrderCommodity::where(['purchase_order_id' => $this->id])->get();
        return $purchaseOrderCommodities;
    }

    public static function savePurchaseOrder($params){
    	if(!isset($params['Commodity'])){
    		return false;
    	}

    	$purchaseOrder = new self;
    	$purchaseOrder->code = 'auto';
    	$purchaseOrder->purchase_date = ($params['purchaseOrder']['purchase_date'] != '') ? $params['purchaseOrder']['purchase_date'] : date('Y-m-d H:i:s');
    	$purchaseOrder->company_id = \Auth::user()->company_id;
    	$purchaseOrder->supplier_id = ($params['purchaseOrder']['supplier_id'] != '') ? $params['purchaseOrder']['supplier_id'] : null;
    	$purchaseOrder->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
    	$purchaseOrder->user_id = ($params['purchaseOrder']['user_id'] != '') ? $params['purchaseOrder']['user_id'] : \Auth::user()->id;
    	$purchaseOrder->note = $params['purchaseOrder']['note'];
    	$purchaseOrder->quantum = count($params['Commodity']);
    	$purchaseOrder->amount_money = $params['purchaseOrder']['amount_money'];
    	$purchaseOrder->sale = $params['purchaseOrder']['sale_money'];
    	$purchaseOrder->total_money = $params['purchaseOrder']['total_money'];
    	$purchaseOrder->payed_money = $params['purchaseOrder']['payed_money'];
    	$purchaseOrder->sale_type = 0;
    	$purchaseOrder->status = self::DONE;

    	\DB::beginTransaction();
        try {
            $purchaseOrder->save();
        	$purchaseOrder->code = 'TBDCN' . $purchaseOrder->id;
        	$purchaseOrder->save();
        	foreach ($params['Commodity'] as $commodity_id => $data) {
        		$purchaseOrderCommodity = new \App\PurchaseOrderCommodity;
        		$purchaseOrderCommodity->purchase_order_id = $purchaseOrder->id;
        		$purchaseOrderCommodity->commodity_id = $commodity_id;
        		$purchaseOrderCommodity->company_id = $purchaseOrder->company_id;
        		$purchaseOrderCommodity->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        		$purchaseOrderCommodity->base_price = $data['price'];
        		$purchaseOrderCommodity->quantum = $data['number'];
        		$purchaseOrderCommodity->sale_money = $data['downprice'];
        		$purchaseOrderCommodity->save();

                # save last price from purchase order
                $product = \App\Commodity::find($commodity_id);
                $product->last_price = $data['price'];
                $product->save();

                # update on hand for commodity
        		\App\BranchCommodity::updateOnHand($commodity_id,$purchaseOrderCommodity->quantum);
        	}
            \DB::commit();
        	return true;
        } catch (\Exception $e) {
            \DB::rollback();
            return false;
        }
    }

    public static function searchPurchaseOrders($input,$paginate=true){
        $purchaseorders = [];
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $queries =  PurchaseOrder::select('purchase_orders.*')
                    ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                    ->leftJoin('purchase_order_commodities', 'purchase_orders.id', '=', 'purchase_order_commodities.purchase_order_id')
                    ->leftJoin('commodities', 'purchase_order_commodities.commodity_id', '=', 'commodities.id');

        $queries->whereNull('purchase_orders.deleted_at')->where(['purchase_orders.company_id'=>\Auth::user()->company_id , 'purchase_orders.branch_id' =>$branch_id]);

        if($input::get('code') != null){
            $queries->where('purchase_orders.code', 'like', "{$input::get('code')}%");
        }

        if($input::get('pcode') != null){
            $queries->where(function ($query) {
                $input = new Input;
                $query->orWhere('commodities.code', 'like', "{$input::get('pcode')}%")
                      ->orWhere('commodities.name', 'like', "{$input::get('pcode')}%");
            });
        }

        if($input::get('note') != null){
            $queries->where('purchase_orders.note', 'like', "{$input::get('note')}%");
        }

        if($input::get('uname') != null){
            $queries->where('purchase_orders.user_id', '=', $input::get('uname'));
        }

        if($input::get('status') != -1){
            $queries->where('purchase_orders.status', '=', $input::get('status'));
        }

        if($input::get('sdate') != null){
            $queries->where('purchase_orders.purchase_date', '>=', $input::get('sdate'));
        }

        if($input::get('edate') != null){
            $queries->where('purchase_orders.purchase_date', '<=', $input::get('edate'));
        }

        if($input::get('scode') != null){
            $queries->where(function ($query) {
                $input = new Input;
                $query->orWhere('suppliers.code', 'like', "{$input::get('scode')}%")
                      ->orWhere('suppliers.name', 'like', "{$input::get('scode')}%");
            });
        }

        if($paginate){
            $purchaseorders = $queries->groupBy('purchase_orders.id')->orderBy('purchase_orders.created_at', 'DESC')->paginate(10);
        }else{
            $purchaseorders = $queries->groupBy('purchase_orders.id')->orderBy('purchase_orders.created_at', 'DESC')->get();
        }

        return $purchaseorders;
    }
}
