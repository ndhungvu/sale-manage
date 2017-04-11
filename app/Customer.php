<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';
    protected $dates = ['deleted_at'];
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;

    public function billSales() {
        return $this-> hasMany('App\BillSale', 'customer_id');
    }
    /*
    * This is function get all groups is active
    */
    public static function getAll() {
    	return Customer::whereNull('deleted_at')->get();
    }

    public static function getCustomerByID($id) {
        return Customer::where('id', $id)->whereNull('deleted_at')->first();
    }

    /*
    * This is function get code auto
    */
    public static function getCode(){
        $max = Customer::max('id');
        return !empty($max) ? 'KH'.($max + 1) : 'KH1';
    }

    /*Check customer is exist*/
    public static function checkExistEmail($email, $company_id) {
        return Customer::where('email', $email)->where('company_id', $company_id)->whereNull('deleted_at')->exists();
    }

    /*Get customers of company*/
    public static function getCustomerByCompanyID($company_id) {
        return Customer::where('company_id', $company_id)->whereNull('deleted_at')->get();
    }
}
