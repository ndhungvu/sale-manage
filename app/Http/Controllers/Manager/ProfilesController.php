<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ManagerController;
use App\User;
use App\Company;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Hash;


class ProfilesController extends ManagerController
{
    CONST LIMIT = 10;

    protected $_USER;

    public function __construct()
    {
        parent::__construct();
        $this->_USER = Auth::user();
    }

    public function postChangeAvatar() {
        if (!empty(Input::file('image'))) {
            $file = Input::file('image');
            $uploadPath = public_path().'/uploads/avatars/';
            if (!is_dir($uploadPath)) {
                if (!@mkdir($uploadPath, 0777, true)) {
                    return response()->json([
                        'status' => false,
                        'message'=> 'Failed to create folders...'
                    ]);
                }
            }

            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), '.'.$extension);
            $fileName = $fileName.'-'.rand(0,1000).'.'.$extension;

            $file->move($uploadPath, $fileName);

            $strImage = '/uploads/avatars/'.$fileName;
            return response()->json([
                    'status' => true,
                    'data'  => $strImage,
                    'message'=> 'Upload image is successful.'
                ]);         
        }else {
            return response()->json([
                    'status' => true,
                    'data'  => '/uploads/avatars/no-image.png',
                    'message'=> 'Upload image is successful.'
                ]);
        }
        return response()->json([
            'status' => false,
            'message'=> 'Upload image is fail.'
        ]);
    }

    /**
     * Get a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getProfile()
    {
        $profile = $this->_USER;
        return View('managers.profiles.detail', compact('profile'));
    }

    /**
     * Edit a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getEditProfile()
    {
        $profile = $this->_USER;
        return View('managers.profiles.edit', compact('profile'));
    }

    /**
     * Edit a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postEditProfile()
    {
        $input = array(
            'name' => Input::get('name'),
        );

        $valid = array(
            'name' => 'required',
        );
        $v = Validator::make($input, $valid);
        if($v->fails()) {
            return Redirect::back()->withInput()->withErrors($v);
        }

        $profile = $this->_USER;
        $profile->name = Input::get('name');
        $profile->address = Input::get('address');
        $profile->phone = Input::get('phone');
        $profile->mobile = Input::get('mobile');
        $profile->cmnd = Input::get('cmnd');    
        $profile->birthday = date('Y-m-d',strtotime(Input::get('birthday')));
        $profile->gender = Input::get('gender');
        if($profile->save()) {
            return Redirect::route('management.profile')->with('flashSuccess', 'Cập nhật tài khoản thành công.');
        }else {
            return Redirect::back()->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Edit a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getChangePassword()
    {
        $profile = $this->_USER;
        return View('managers.profiles.change-password', compact('profile'));
    }

    /**
     * Edit a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postChangePassword()
    {
        $input = array(
            'old_password' => Input::get('old_password'),
            'new_password' => Input::get('new_password')
        );

        $valid = array(
            'old_password' => 'required',
            'new_password' => 'required'
        );
        $v = Validator::make($input, $valid);
        if($v->fails()) {
            return Redirect::back()->withInput()->withErrors($v);
        }

        $profile = $this->_USER;
        $profile->password = Hash::make(Input::get('new_password'));        
        if($profile->save()) {
            return Redirect::route('management.profile')->with('flashSuccess', 'Cập nhật mật khẩu mới thành công.');
        }else {
            return Redirect::back()->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }
    
    /**
     * Check email exist
     * @Author: Vu Nguyen
     * @Created: 07-26-2016
     */
    public function postCheckPassword(Request $request) {
        $password = Input::get('old_password');
        $nickname = $this->_USER->nickname;
        $data = Input::all();
        if (!Auth::attempt(['nickname' => $nickname, 'password' => $password, 'deleted_at'=> NULL])) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
}
