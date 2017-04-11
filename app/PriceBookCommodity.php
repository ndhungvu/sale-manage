<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceBookCommodity extends Model
{
    protected $table = 'price_book_commodities';

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

    public static function getPriceBook($price_book_id, $commodity_id) {
        $result =  self::select('base_book_price')->where('price_book_id', $price_book_id)->where('commodity_id',$commodity_id)->first();
        return !empty($result) ? $result->base_book_price : 0;
    }
}
