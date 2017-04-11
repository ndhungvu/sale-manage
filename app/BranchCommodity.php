<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchCommodity extends Model
{
    use SoftDeletes;
    protected $table = 'branch_commodities';

    public static function updateOnHand($commodityID,$numMore,$rewrite=false, $branch_id = null){
    	\DB::beginTransaction();
    	try {
            if($branch_id == null){
                $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
            }
            
    		$branch_commodity = \App\BranchCommodity::where(['branch_id'=> $branch_id, 'commodity_id' => $commodityID, 'company_id' => \Auth::user()->company_id])->first();
            
            if(is_null($branch_commodity)){
                $branch_commodity = new self;
                $branch_commodity->company_id = \Auth::user()->company_id;
                $branch_commodity->branch_id = $branch_id;
                $branch_commodity->commodity_id = $commodityID;
                $branch_commodity->on_hand = 0;
            }

            $old_on_hand = $branch_commodity->on_hand;

            if($rewrite == true){
                $branch_commodity->on_hand = $numMore;
            }else{
                $branch_commodity->on_hand = $branch_commodity->on_hand+$numMore;
            }
	    	$branch_commodity->save();

	    	$commodity = \App\Commodity::find($commodityID);

            if($rewrite == true){
                $commodity->on_hand = $commodity->on_hand-$old_on_hand+$numMore;
            }else{
                $commodity->on_hand = $commodity->on_hand+$numMore;
            }
	    	$commodity->save();
	    	\DB::commit();
	    	return true;
    	} catch (Exception $e) {
    		\DB::rollback();
            return false;
    	}
    }

    public function commodity()
    {
        return $this->belongsTo('App\Commodity', 'commodity_id');
    }

    /*Get publish products by branch*/
    public static function getPublishProductsByBranch($branch_id,$params = null) {
        if(!empty($params) && !empty($params->get('book'))){

            $book = $params->get('book');
            $commodities = self::where('branch_id', $branch_id)
            ->select('branch_commodities.*','price_book_commodities.base_book_price')
            ->leftJoin('price_book_commodities', function($join) use ($book){
                    $join->on('branch_commodities.commodity_id', '=', 'price_book_commodities.commodity_id');
                    $join->where('price_book_commodities.price_book_id', '=', $book);
            })
            ->with('commodity')->orderBy('branch_commodities.id','DESC')->paginate(24);
        }else{        
            $commodities = self::where('branch_id', $branch_id)->with('commodity')->orderBy('branch_commodities.id','DESC')->paginate(24);
        }
        //dd($commodities);
        return $commodities;
    }

    /*Get branch commodity*/
    public static function getBranchCommodity($branch_id, $commodity_id) {
        return self::where('branch_id',$branch_id)->where('commodity_id',$commodity_id)->with('commodity')->first();
    }
}
