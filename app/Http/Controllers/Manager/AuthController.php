<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Hash;
use Session;

class AuthController extends Controller
{
    /*This is function login to admin system*/
    public function getLogin() {
        if(Auth::check()) {
            //return Redirect::intended();
            return Redirect::route('management.dashboard');
        }
        Session::put('url.intended',url()->previous());
        return View('managers.auth.login');
    }

    /*
    *Login
    *@Author: Vu Nguyen
    *@Created: 01-06-2016
    */
    public function postLogin(Request $request) {
        $input = array(
            'account' => Input::get('account'),
            'password' => Input::get('password')
        );

        $rules = array(
           'account' => 'required',
           'password' => 'required'
        );
        $valid = Validator::make($input, $rules);
        if($valid->fails()) {
            return Redirect::back()->withErrors($valid);
        }
        session(['current_branch' => 0]);
        if (Auth::attempt(['nickname' => $request->account, 'password' => $request->password, 'role_id' => 2, 'deleted_at'=> NULL], true) 
            || Auth::attempt(['email'=> $request->account, 'password' => $request->password, 'role_id' => 2, 'deleted_at'=> NULL], true)
            || Auth::attempt(['nickname'=> $request->account, 'password' => $request->password, 'role_id' => 3, 'deleted_at'=> NULL], true)
            || Auth::attempt(['email'=> $request->account, 'password' => $request->password, 'role_id' => 3, 'deleted_at'=> NULL], true)
            ) {
            $user = Auth::user();

            $companyBranches = \App\Branch::whereNull('branches.deleted_at')->where(['branches.company_id'=> $user->company_id, 'branches.status'=>\App\Branch::ACTIVE])->get()->toArray();
            if(!empty($companyBranches)){
                if($user->role_id == 3){
                    session(['current_branch' => $user->branch_id]);
                }else{
                    $companyBranch = reset($companyBranches);
                    session(['current_branch' => $companyBranch['id']]);
                }
            }else{
                session(['current_branch' => 0]);
            }
            return Redirect::route('management.dashboard')->with('flashSuccess', 'Đăng nhập thành công.');
        }
        
        return Redirect::back()->with('flashError', 'Tài khoản và mật khẩu là không hợp lệ');
    }

    /*
    *Logout
    *@Author: Vu Nguyen
    *@Created: 01-06-2016
    */
    public function getLogout() {
        Auth::logout();
        return Redirect::route('management.login');
    }
}
