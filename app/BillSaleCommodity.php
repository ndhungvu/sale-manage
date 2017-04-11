<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillSaleCommodity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bill_sale_commodities';

    
    public static function tempCommodityByBillID($bill_sale_id, $commodity_id) {
        return self::where('bill_sale_id', $bill_sale_id)
        		->where('commodity_id', $commodity_id)->first();
    }

    public function commodity()
    {
        return $this->belongsTo('App\Commodity', 'commodity_id');
    }

    public static function getTempBills($bill_sale_id) {
        return self::where('bill_sale_id', $bill_sale_id)->get();
    }

}
