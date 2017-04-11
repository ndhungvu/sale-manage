<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;

class DamageItem extends Model
{
	use SoftDeletes;
	protected $table = 'damage_items';
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
    			return 'Hoàn thành';
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

    public function getCreator(){
        $creator = \App\User::find($this->user_id);
        return ($creator == null) ? '' : !empty($creator->name) ? $creator->name : $creator->nickname;
    }

    public function getCommodities(){
        $damageItemCommodities = \App\DamageItemCommodity::where(['damage_item_id' => $this->id])->get();
        return $damageItemCommodities;
    }

    public static function saveDamageItem($params){
    	if(!isset($params['Commodity'])){
    		return false;
    	}
    	$damageItem = new self;
    	$damageItem->code = 'auto';
    	$damageItem->trans_date = ($params['damageItem']['trans_date'] != '') ? $params['damageItem']['trans_date'] : date('Y-m-d H:i:s');
    	$damageItem->company_id = \Auth::user()->company_id;
    	$damageItem->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
    	$damageItem->user_id = ($params['damageItem']['user_id'] != '') ? $params['damageItem']['user_id'] : \Auth::user()->id;
    	$damageItem->note = $params['damageItem']['note'];
    	$damageItem->quantum = $params['damageItem']['quantum'];
    	$damageItem->status = self::DONE;

    	\DB::beginTransaction();
        try {
            $damageItem->save();
        	$damageItem->code = 'XH' . $damageItem->id;
        	$damageItem->save();
        	foreach ($params['Commodity'] as $commodity_id => $data) {
        		$damageItemCommodity = new \App\DamageItemCommodity;
        		$damageItemCommodity->damage_item_id = $damageItem->id;
        		$damageItemCommodity->commodity_id = $commodity_id;
        		$damageItemCommodity->company_id = $damageItem->company_id;
        		$damageItemCommodity->branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        		$damageItemCommodity->quantum = $data['number'];
        		$damageItemCommodity->save();

                # update on hand for commodity
                $num_on_hand = (0-$damageItemCommodity->quantum);
        		\App\BranchCommodity::updateOnHand($commodity_id,$num_on_hand);
        	}
            \DB::commit();
        	return true;
        } catch (\Exception $e) {
            \DB::rollback();
            return false;
        }
    }

    public static function searchDamageItems($input,$paginate=true){
        $purchaseorders = [];
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $queries =  DamageItem::select('damage_items.*')
                    ->leftJoin('damage_item_commodities', 'damage_items.id', '=', 'damage_item_commodities.damage_item_id')
                    ->leftJoin('commodities', 'damage_item_commodities.commodity_id', '=', 'commodities.id');

        $queries->whereNull('damage_items.deleted_at')->where(['damage_items.company_id'=>\Auth::user()->company_id, 'damage_items.branch_id' =>$branch_id]);

        if($input::get('code') != null){
            $queries->where('damage_items.code', 'like', "{$input::get('code')}%");
        }

        if($input::get('pcode') != null){
            $queries->where(function ($query) {
                $input = new Input;
                $query->orWhere('commodities.code', 'like', "{$input::get('pcode')}%")
                      ->orWhere('commodities.name', 'like', "{$input::get('pcode')}%");
            });
        }

        if($input::get('note') != null){
            $queries->where('damage_items.note', 'like', "{$input::get('note')}%");
        }

        if($input::get('uname') != null){
            $queries->where('damage_items.user_id', '=', $input::get('uname'));
        }

        if($input::get('status') != -1){
            $queries->where('damage_items.status', '=', $input::get('status'));
        }

        if($input::get('sdate') != null){
            $queries->where('damage_items.trans_date', '>=', $input::get('sdate'));
        }

        if($input::get('edate') != null){
            $queries->where('damage_items.trans_date', '<=', $input::get('edate'));
        }

        if($paginate){
            $purchaseorders = $queries->groupBy('damage_items.id')->orderBy('damage_items.created_at', 'DESC')->paginate(10);
        }else{
            $purchaseorders = $queries->groupBy('damage_items.id')->orderBy('damage_items.created_at', 'DESC')->get();  
        }
        

        return $purchaseorders;
    }
}
