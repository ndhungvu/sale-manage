<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ManagerController;
use App\User;
use App\Branch;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Hash;


class StaffsController extends ManagerController
{
    CONST LIMIT = 10;
    /**
     * Display a listing of the resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getIndex()
    {
        /*Get branches*/
        $branches = Branch::getBranchesByCompanyID(Auth::user()->company_id);
        $users = User::select('users.*')
                ->where('role_id', User::ROLE_STAFF)
                ->where('company_id','=',Auth::user()->company_id)
                ->whereNull('users.deleted_at')
                ->orderBy('users.created_at', 'DESC')
                ->paginate($this::LIMIT);
        return View('managers.staffs.index', compact('users','branches'));
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
            $photos->image = 'no-image.png';
        }
        return response()->json([
            'status' => false,
            'message'=> 'Upload image is fail.'
        ]);
    }

    /**
     * Creating a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postCreate()
    {
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
        $user->code = User::getCode();
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
        $user->company_id = Auth::user()->company_id;
        $user->branch_id = Input::get('branch_id');
        $user->role_id = User::ROLE_STAFF;

        $image_tmp = Input::get('image_tmp');
        if(!empty($image_tmp)) {
            $user->avatar = basename($image_tmp);
        }else {
            $user->avatar = basename(Input::get('image_old'));
        }

        if($user->save()) {
            return Redirect::route('management.staffs')->with('flashSuccess', 'Thêm nhân viên thành công.');
        }else {
            return Redirect::route('management.staffs')->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Edit a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getEdit($id) {
        $user = User::getUserByID($id);
        /*Get Roles*/
        $roles = Role::whereNull('deleted_at')->where('status', Role::ACTIVE)->lists('name', 'id');
        return View('managers.staffs.edit', compact('user','roles'));
    }

    /**
     * Edit a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postEdit($id) {
        $input = array(
            'name' => Input::get('name'),
            'nickname' => Input::get('nickname'),
            'email' => Input::get('email')
        );

        $valid = array(
            'name' => 'required',
            'nickname' => 'required',
            'email' => 'required'
        );

        $v = Validator::make($input, $valid);
        if($v->fails()) {
            return Redirect::back()->withInput()->withErrors($v);
        }

        $user = User::getUserByID($id);
        $user->name = Input::get('name');
        $user->nickname = Input::get('nickname');
        $user->email = Input::get('email');       
        $user->address = Input::get('address');
        $user->phone = Input::get('phone');
        $user->mobile = Input::get('mobile');
        $user->cmnd = Input::get('cmnd');
        $user->mst = Input::get('mst');
        $user->birthday = date('Y-m-d',strtotime(Input::get('birthday')));
        $user->gender = Input::get('gender');
        $user->branch_id = Input::get('branch_id');
        if(!empty(Input::get('password'))){
            $user->password = Hash::make(Input::get('password'));   
        }

        $image_tmp = Input::get('image_tmp');
        if(!empty($image_tmp)) {
            $user->avatar = basename($image_tmp);
        }else {
            $user->avatar = basename(Input::get('image_old'));
        }
        
        if($user->save()) {
            return Redirect::route('management.staffs')->with('flashSuccess', 'Cập nhật nhân viên thành công.');
        }else {
            return Redirect::route('management.staffs')->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Show detail a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getDetail($id) {
        $user = User::getUserByID($id);
        return View('managers.staffs.detail', compact('user'));
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
                $user->deleted_at = date('Y-m-d H:i:s', time());
                if($user->save()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Nhân viên đã được xóa thành công.'
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
                        'message'=> 'Nhân viên không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 500);
            }
        }
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
        if(User::checkExistEmail(Input::get('email'), Input::get('id'))) {
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
}
