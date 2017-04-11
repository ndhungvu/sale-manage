<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'companies';
    protected $dates = ['deleted_at'];
    //use SoftDeletes;
    CONST ACTIVE = 1;
    CONST UNACTIVE = 0;

    /*Branches of company*/
    public function branches()
    {
        return $this->hasMany('App\Branch', 'company_id', 'id')->whereNull('branches.deleted_at');
    }
    /*
    * This is function get all groups is active
    */
    public static function getAll() {
    	return Company::whereNull('deleted_at')->get();
    }

    public static function getCompanyByID($id) {
        return Company::where('id', $id)->whereNull('deleted_at')->first();
    }
}
