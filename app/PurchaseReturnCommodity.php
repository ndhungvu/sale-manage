<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnCommodity extends Model
{
    protected $table = 'purchase_return_commodities';

    protected $commodityCache;

    public function getCommodityCode(){
    	if(!is_null($this->commodityCache)){
    		return $this->commodityCache->code;
    	}
    	
    	$commodity = \App\Commodity::find($this->commodity_id);
    	if(!is_null($commodity)){
    		$this->commodityCache = $commodity;
    		return $commodity->code;
    	}
    	
    	return '';
    }

    public function getCommodityName(){
    	if(!is_null($this->commodityCache)){
    		return $this->commodityCache->name;
    	}

    	$commodity = \App\Commodity::find($this->commodity_id);
    	if(!is_null($commodity)){
    		$this->commodityCache = $commodity;
    		return $commodity->name;
    	}

    	return '';
    }
}
