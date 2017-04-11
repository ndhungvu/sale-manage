<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Company;
use App\Library\Helper;
use App\Branch;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Hash;


class UsersController extends Controller
{
    CONST LIMIT = 10;

    protected $_USER;

    public function __construct()
    {
        $this->_USER = Auth::user();
    }

    /**
     * Display a listing of the resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getIndex()
    {
        /*Get all companies*/
        $companies = Company::getAll();
        $users = User::select('users.*')
                ->where('role_id', User::ROLE_MANAGER)
                ->whereNull('users.deleted_at')
                ->orderBy('users.created_at', 'DESC');

        if(!empty(Input::get('search'))) {           
            $users = $users->where(function ($query) {
                $search = Input::get('search');
                $query->orWhere('nickname', 'like', '%'.$search.'%')
                      ->orWhere('name', 'like', '%'.$search.'%')
                      ->orWhere('mobile', 'like', '%'.$search.'%')
                      ->orWhere('phone', 'like', '%'.$search.'%');
            });
        }
        if(!empty(Input::get('time_from')) && !empty(Input::get('time_to'))) {
            $time_from = Input::get('time_from');
            $time_to = Input::get('time_to');
            $users = $users->whereBetween('created_at', array($time_from, $time_to));
        }

        $users = $users->paginate($this::LIMIT);
        return View('admins.users.index', compact('users','companies'));
    }

    /**
     * Creating a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postCreate()
    {
        $company_id = Input::get('company_id');
        $input = array(
            'name' => Input::get('name'),
            'nickname' => Input::get('nickname'),
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );

        $valid = array(
            'name' => 'required',
            'nickname' => 'required',
            'email' => 'required',
            'password' => 'required'
        );

        $v = Validator::make($input, $valid);
        if($v->fails()) {
            return Redirect::back()->withInput()->withErrors($v);
        }

        $user = new User();
        $user->name = Input::get('name');
        $user->nickname = Input::get('nickname');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));        
        $user->address = Input::get('address');
        $user->phone = Input::get('phone');
        $user->mobile = Input::get('mobile');
        $user->cmnd = Input::get('cmnd');
        $user->mst = Input::get('mst');
        $user->birthday = date('Y-m-d',strtotime(Input::get('birthday')));
        $user->gender = Input::get('gender');
        $user->status = 1;
        $user->company_id = $company_id;
        $user->branch_id = Branch::getBranchCenter($company_id);
        $user->role_id = User::ROLE_MANAGER;

        $image_tmp = Input::get('image_tmp');
        if(!empty($image_tmp)) {
            $user->avatar = basename($image_tmp);
        }else {
            $user->avatar = basename(Input::get('image_old'));
        }

        if($user->save()) {
            return Redirect::route('admin.users')->with('flashSuccess', 'Thêm người dùng thành công.');
        }else {
            return Redirect::route('admin.users')->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Edit a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postEdit($id) {
        $input = array(
            'name' => Input::get('name')
        );

        $valid = array(
            'name' => 'required'            
        );

        $v = Validator::make($input, $valid);
        if($v->fails()) {
            return Redirect::back()->withInput()->withErrors($v);
        }

        $user = User::getUserByID($id);
        $user->name = Input::get('name');    
        $user->address = Input::get('address');
        $user->phone = Input::get('phone');
        $user->mobile = Input::get('mobile');
        $user->cmnd = Input::get('cmnd');
        $user->mst = Input::get('mst');
        $user->birthday = date('Y-m-d',strtotime(Input::get('birthday')));
        $user->gender = Input::get('gender');
        $user->company_id = Input::get('company_id');
        if(Input::get('password')) {
            $user->password = Hash::make(Input::get('password')); 
        }

        $image_tmp = Input::get('image_tmp');
        if(!empty($image_tmp)) {
            $user->avatar = basename($image_tmp);
        }else {
            $user->avatar = basename(Input::get('image_old'));
        }

        if($user->save()) {
            return Redirect::route('admin.users')->with('flashSuccess', 'Cập nhật người dùng thành công.');
        }else {
            return Redirect::back()->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Delete a resource.
     * @Author: Vu Nguyen
     * @Created: 04-12-2015
     */
    public function postDelete($id) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $user = User::getUserByID($id);
            if(!empty($user)) {                
                if($user->delete()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Người dùng đã được xóa thành công.'
                    ]);
                }else {
                    return response()->json([
                        'status' => false,
                        'message'=> 'Đã xảy ra lỗi, vui lòng thử lại.'
                    ], 500);
                }
            }else {
                return response()->json([
                        'status' => false,
                        'message'=> 'Người dùng không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 500);
            }
        }
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

    public function postAutoNickname() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $hashed = Helper::hash();
            return response()->json([
                        'status' => true,
                        'data'=> $hashed,
                        'message'=> 'Lấy tên đăng nhập tự động thành công.'
                    ]);
        }
    }

    public function postAutoPassword() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $hashed = Helper::hash();
            return response()->json([
                        'status' => true,
                        'data'=> $hashed,
                        'message'=> 'Lấy mật khẩu tự động thành công!'
                    ]);
        }
    }

    /**
     * Check email exist
     * @Author: Vu Nguyen
     * @Created: 07-26-2016
     */
    public function postCheckExistEmail() {
        if(User::checkExistEmail(Input::get('email'))) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * Check email exist
     * @Author: Vu Nguyen
     * @Created: 07-26-2016
     */
    public function postCheckExistNickname() {
        if(User::checkExistNickname(Input::get('nickname'), Input::get('id'))) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * Get a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getProfile()
    {
        $profile = $this->_USER;
        return View('admins.users.profile', compact('profile'));
    }

    /**
     * Edit a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getEditProfile()
    {
        $profile = $this->_USER;
        return View('admins.users.profile-edit', compact('profile'));
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
            return Redirect::route('admin.profile')->with('flashSuccess', 'Cập nhật tài khoản thành công.');
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
        return View('admins.users.change-password', compact('profile'));
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
            return Redirect::route('admin.profile')->with('flashSuccess', 'Cập nhật mật khẩu mới thành công.');
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
        if (!Auth::attempt(['nickname' => $nickname, 'password' => $password, 'role_id' => 1, 'deleted_at'=> NULL])) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
}
