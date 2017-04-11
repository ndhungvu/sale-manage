<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'branches';
    protected $dates = ['deleted_at'];
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;

    /*
    * This is function get all groups is active
    */
    public static function getAll() {
    	return Branch::whereNull('deleted_at')->get();
    }

    public static function getBranchByID($id) {
        return Branch::where('id', $id)->whereNull('deleted_at')->first();
    }

    public static function getBranchesByCompanyID($company_id){
        return Branch::where('company_id', $company_id)->whereNull('deleted_at')->get();
    }

    public static function getBranchCenter($company_id){
        return Branch::where('company_id', $company_id)->whereNull('deleted_at')->min('id');
    }
}
