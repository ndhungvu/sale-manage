<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\Auth;
use Hash;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use SoftDeletes;
    CONST ROLE_ADMIN = 1;
    CONST ROLE_MANAGER = 2;
    CONST ROLE_STAFF = 3;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function getBranchName(){
        if($this->branch_id == 0)
            return 'Chi nhánh trung tâm';

        $branch = \App\Branch::find($this->branch_id);
        return ($branch == null) ? '' : $branch->name;
    }

    /*
    * This is function get all users is active
    */
    public static function getAll() {
        return User::whereNull('deleted_at')->get();
    }

    public static function getUserByID($id) {
        return User::where('id', $id)->whereNull('deleted_at')->first();
    }

    // public function role() {
    //     return $this->belongsTo('App\Role','role_id','id');
    // }

    public static function getUserByEmail($email) {
        return User::where('email', $email)->whereNull('deleted_at')->first();
    }

    public static function getUserByFacebookID($facebook_id) {
        return User::where('facebook_id', $facebook_id)->whereNull('deleted_at')->first();
    }

    public static function getUserByTwitterID($twitter_id) {
        return User::where('twitter_id', $twitter_id)->whereNull('deleted_at')->first();
    }

    /*
    * This is function get code auto
    */
    public static function getCode(){
        $max = User::where('role_id', 2)->max('id');
        return !empty($max) ? 'NV'.($max + 1) : 'NV1';
    }

    /*Check supplier is exist*/
    public static function checkExistEmail($email,$id=null) {
        return User::where('email', $email)->where('id','<>',$id)->whereNull('deleted_at')->exists();
    }

    /*Check supplier is exist*/
    public static function checkExistNickname($nickname,$id=null) {
        return User::where('nickname', $nickname)->where('id','<>',$id)->whereNull('deleted_at')->exists();
    }

    public static function getStaffByCompanyID($company_id){
        return User::whereNull('deleted_at')->where('company_id', (int) $company_id)->whereIn('role_id',[self::ROLE_STAFF, self::ROLE_MANAGER])->get();
    }
}
