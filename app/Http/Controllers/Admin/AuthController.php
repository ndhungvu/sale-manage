<?php

namespace App\Http\Controllers\Admin;

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
            return Redirect::route('admin.dashboard');
        }
        Session::put('url.intended',url()->previous());
        return View('admins.auth.login');
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

        if (Auth::attempt(['nickname' => $request->account, 'password' => $request->password, 'role_id' => 1, 'deleted_at'=> NULL], true)) {
            $user = Auth::user();
            return Redirect::route('admin.companies')->with('flashSuccess', 'Đăng nhập thành công.');
            //return Redirect::intended()->with('flashSuccess', 'Đăng nhập thành công.');
        }elseif (Auth::attempt(['email'=> $request->account, 'password' => $request->password, 'role_id' => 1, 'deleted_at'=> NULL], true)) {
            $user = Auth::user();
            return Redirect::route('admin.companies')->with('flashSuccess', 'Đăng nhập thành công.');
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
        return Redirect::route('admin.login');
    }
}
