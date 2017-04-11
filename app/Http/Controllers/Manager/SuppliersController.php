<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ManagerController;
use App\Supplier;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;


class SuppliersController extends ManagerController
{
    CONST LIMIT = 10;
    /**
     * Display a listing of the resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getIndex()
    {
        $suppliers = Supplier::whereNull('deleted_at')                    
                    ->where('company_id','=',Auth::user()->company_id)
                    ->orderBy('created_at', 'DESC');
        if(!empty(Input::get('search'))) {           
            $suppliers = $suppliers->where(function ($query) {
                $search = Input::get('search');
                $query->orWhere('code', 'like', '%'.$search.'%')
                      ->orWhere('name', 'like', '%'.$search.'%')
                      ->orWhere('mobile', 'like', '%'.$search.'%')
                      ->orWhere('phone', 'like', '%'.$search.'%');
            });
        }
        if(!empty(Input::get('time_from')) && !empty(Input::get('time_to'))) {
            $time_from = Input::get('time_from');
            $time_to = Input::get('time_to');
            $suppliers = $suppliers->whereBetween('created_at', array($time_from, $time_to));
        }
        $suppliers = $suppliers->paginate($this::LIMIT);
        return View('managers.suppliers.index', compact('suppliers'));
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

        $supplier = new Supplier();
        $supplier->code = Supplier::getCode();
        $supplier->name = Input::get('name');
        $supplier->email = Input::get('email');
        $supplier->address = Input::get('address');
        $supplier->phone = Input::get('phone');
        $supplier->mobile = Input::get('mobile');
        $supplier->mst = Input::get('mst');
        $supplier->company_id = Auth()->user()->company_id;
        $supplier->status = 1;

        if($supplier->save()) {
            return Redirect::route('management.suppliers')->with('flashSuccess', 'Thêm mới nhà cung cấp thành công!');
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
        $supplier = Supplier::getSupplierByID($id);

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
        
        $supplier->name = Input::get('name');
        $supplier->email = Input::get('email');
        $supplier->address = Input::get('address');
        $supplier->phone = Input::get('phone');
        $supplier->mobile = Input::get('mobile');
        $supplier->mst = Input::get('mst');

        if($supplier->save()) {
            return Redirect::route('management.suppliers')->with('flashSuccess', 'Cập nhật nhà cung cấp thành công.');
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
            $customer = Supplier::getSupplierByID($id);
            if(!empty($customer)) {                
                if($customer->delete()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Nhà cung cấp đã được xóa thành công.'
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
                        'message'=> 'Nhà cung cấp không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 500);
            }
        }
    }

    /**
     * Check email exist
     * @Author: Vu Nguyen
     * @Created: 07-26-2016
     */
    public function postCheckExistEmail() {
        $company_id = Auth::user()->company_id;
        if(Supplier::checkExistEmail(Input::get('email'), $company_id)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }
}
