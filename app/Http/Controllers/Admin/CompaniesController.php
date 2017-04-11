<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Company;
use App\Branch;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;


class CompaniesController extends Controller
{
    CONST LIMIT = 10;
    /**
     * Display a listing of the resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getIndex()
    {
        $companies = Company::whereNull('deleted_at');                    
        if(!empty(Input::get('search'))) {           
            $companies = $companies->where(function ($query) {
                $search = Input::get('search');
                $query->orWhere('name', 'like', '%'.$search.'%')
                      ->orWhere('mobile', 'like', '%'.$search.'%')
                      ->orWhere('phone', 'like', '%'.$search.'%');
            });
        }
        if(!empty(Input::get('time_from')) && !empty(Input::get('time_to'))) {
            $time_from = Input::get('time_from');
            $time_to = Input::get('time_to');
            $companies = $companies->whereBetween('created_at', array($time_from, $time_to));
        }
        $companies = $companies->orderBy('created_at','DESC')->paginate($this::LIMIT);
        return View('admins.companies.index', compact('companies'));
    }

    /**
     * Creating a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postCreate()
    {
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

        $company = new Company();
        $company->name = Input::get('name');
        $company->email = Input::get('email');
        $company->address = Input::get('address');
        $company->phone = Input::get('phone');
        $company->mobile = Input::get('mobile');
        $company->date_close = Input::get('date_close');
        $company->status = 1;

        if($company->save()) {
            $branch = new Branch();
            $branch->name = 'Chi nhánh trung tâm';
            $branch->company_id = $company->id;
            $branch->status = 1;
            if($branch->save()) {
                return Redirect::route('admin.companies')->with('flashSuccess', 'Thêm mới công ty thành công!');
            }
        }else {
            return Redirect::back()->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    /**
     * Edit a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postEdit($id) {
        $company = Company::getCompanyByID($id);

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
        
        $company->name = Input::get('name');
        $company->email = Input::get('email');
        $company->address = Input::get('address');
        $company->phone = Input::get('phone');
        $company->mobile = Input::get('mobile');
        $company->date_close = Input::get('date_close');
        if($company->save()) {
            return Redirect::route('admin.companies')->with('flashSuccess', 'Cập nhật công ty thành công.');
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
            $company = Company::getCompanyByID($id);
            if(!empty($company)) {                
                if($company->branches()->delete() && $company->delete()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Công ty đã được xóa thành công.'
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
                        'message'=> 'Công ty không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 500);
            }
        }
    }

    /**
     * Creating a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postCreateBranch($company_id)
    {
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

        $branch = new Branch();
        $branch->name = Input::get('name');
        $branch->address = Input::get('address');
        $branch->phone = Input::get('phone');
        $branch->mobile = Input::get('mobile');
        $branch->company_id = $company_id;
        $branch->status = 1;

        if($branch->save()) {
            return Redirect::route('admin.companies')->with('flashSuccess', 'Thêm mới chi nhánh thành công!');
        }else {
            return Redirect::back()->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    /**
     * Edit a resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postEditBranch($company_id, $id) {
        $branch = Branch::getBranchByID($id);

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
        
        $branch->name = Input::get('name');
        $branch->address = Input::get('address');
        $branch->phone = Input::get('phone');
        $branch->mobile = Input::get('mobile');
        if($branch->save()) {
            return Redirect::route('admin.companies')->with('flashSuccess', 'Cập nhật chi nhánh thành công.');
        }else {
            return Redirect::back()->with('flashError', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Delete a resource.
     * @Author: Vu Nguyen
     * @Created: 04-12-2015
     */
    public function postDeleteBranch($company_id, $id) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $branch = Branch::getBranchByID($id);
            if(!empty($branch)) {                
                if($branch->delete()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Chi nhánh đã được xóa thành công.'
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
                        'message'=> 'Chi nhánh không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 500);
            }
        }
    }
  }
