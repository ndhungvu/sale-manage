<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suppliers';
    protected $dates = ['deleted_at'];
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;

    /*
    * This is function get all groups is active
    */
    public static function getAll() {
    	return Supplier::whereNull('deleted_at')->get();
    }

    public static function getByCompanyID($company_id) {
        return Supplier::whereNull('deleted_at')->where('company_id',$company_id)->get();
    }

    public static function getSupplierByID($id) {
        return Supplier::where('id', $id)->whereNull('deleted_at')->first();
    }

    /*
    * This is function get code auto
    */
    public static function getCode(){
        $max = Supplier::max('id');
        return !empty($max) ? 'NCC'.($max + 1) : 'NCC1';
    }

    /*Check supplier is exist*/
    public static function checkExistEmail($email, $company_id) {
        return Supplier::where('email', $email)->where('company_id', $company_id)->whereNull('deleted_at')->exists();
    }
}
