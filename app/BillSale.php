<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class BillSale extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bill_sales';
    protected $dates = ['deleted_at'];
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;
    CONST TEMP = 0;

    public function bill_sale_commodities()
    {
        return $this-> hasMany('App\BillSaleCommodity', 'bill_sale_id');
    }

    public function staff() {
        return $this->belongsTo('App\User','user_id');
    }

    public function company()  {
        return $this->belongsTo('App\Company','company_id');
    }

    public function branch()  {
        return $this->belongsTo('App\Branch','branch_id');
    }

    public function customer()  {
        return $this->belongsTo('App\Customer','customer_id');
    }

    /*
    * This is function get all groups is active
    */
    public static function getBillSaleByID($id) {
        return self::where('id', $id)->whereNull('deleted_at')->first();
    }

    public static function tempBillsByUser($user_id) {
        return self::where('user_id', $user_id)
                ->where('status', '=', self::TEMP)->whereNull('deleted_at')->get();
    }

    public static function getTempCode() {
        $max = self::where('status', '=', self::TEMP)->max('id');
        return !empty($max) ? 'TEMP'.($max + 1) : 'TEMP1';
    }

    public static function getCode() {
        $max = self::where('status', '=', self::ACTIVE)->max('id');
        return !empty($max) ? 'HDBH'.($max + 1) : 'HDBH1';
    }

    public static function getBillSales($company_id, $branch_id = null, $sale_date, $customer_id = null) {
        $bills =  self::where('company_id', $company_id);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        if(!empty($sale_date)) {
            $bills = $bills->whereDate('sale_date', '=', $sale_date);
        }
        if(!empty($customer_id)) {
            $bills = $bills->where('customer_id', '=', $customer_id);
        }
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')->get();
        return $bills;
    }

    /*report sale by date*/
    public static function getReportBillSales($company_id, $branch_id = null, $time_start, $time_end) {
        $bills =  self::selectRaw('DATE(sale_date) AS sale_date, sum(total) as sum, sum(base_price_total) as base_total')
                     ->where('company_id', $company_id);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')
                ->groupBy(DB::raw('DAY(sale_date)'))
                ->orderBy('sale_date','DESC')
                ->get();
        return $bills;
    }

    /*report sale by month*/
    public static function getReportBillSalesMonth($company_id, $branch_id = null) {
        $bills =  self::selectRaw('MONTH(sale_date) AS month, sum(total) as sum, sum(base_price_total) as base_total')
                     ->where('company_id', $company_id);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        $time_start = date('Y-01-01');
        $time_end = date('Y-12-31');
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')
                ->whereBetween('sale_date', array($time_start, $time_end))
                ->groupBy(DB::raw('MONTH(sale_date)'))
                ->orderBy('sale_date','ASC')
                ->get();
        return $bills;
    }

    /*report sale by quarter*/
    public static function getReportBillSalesByQuarter($company_id, $branch_id = null) {
         $bills =  self::selectRaw('QUARTER(sale_date) AS month, sum(total) as sum, sum(base_price_total) as base_total')
                     ->where('company_id', $company_id);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        $time_start = date('Y-01-01');
        $time_end = date('Y-12-31');
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')
                ->whereBetween('sale_date', array($time_start, $time_end))
                ->groupBy(DB::raw('QUARTER(sale_date)'))
                ->orderBy('sale_date','ASC')
                ->get();
        return $bills;
    }

    /*report sale by year*/
    public static function getReportBillSalesByYear($company_id, $branch_id = null) {
        $bills =  self::selectRaw('Year(sale_date) AS year, sum(total) as sum, sum(base_price_total) as base_total')
                     ->where('company_id', $company_id);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')
                ->groupBy(DB::raw('Year(sale_date)'))
                ->orderBy('sale_date','DESC')
                ->get();
        return $bills;
    }

    /*report sale by staff*/
    public static function getReportBillSalesByStaff($company_id, $branch_id = null, $time_start, $time_end) {
        $bills =  self::selectRaw('user_id, sum(total) as sum, sum(base_price_total) as base_total')
                     ->where('company_id', $company_id);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')
                ->whereBetween('sale_date', array($time_start, $time_end))
                ->groupBy(DB::raw('user_id'))
                ->orderBy('sum','DESC')
                ->limit(10)
                ->get();
        return $bills;
    }

    /*report sale by staff*/
    public static function getReportBillSalesByCustomer($company_id, $branch_id = null, $time_start, $time_end) {
        $bills =  self::selectRaw('customer_id, sum(total) as sum, sum(base_price_total) as base_total')
                     ->where('company_id', $company_id)
                     ->where('customer_id','!=', 0);
        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        $bills = $bills->where('status', '=', self::ACTIVE)->whereNull('deleted_at')
                ->whereBetween('sale_date', array($time_start, $time_end))
                ->groupBy(DB::raw('customer_id'))
                ->orderBy('sum','DESC')
                ->limit(10)
                ->get();
        return $bills;
    }
}
