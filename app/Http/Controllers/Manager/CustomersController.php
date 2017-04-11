<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ManagerController;
use App\Customer;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;


class CustomersController extends ManagerController
{
    CONST LIMIT = 10;
    /**
     * Display a listing of the resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getIndex()
    {
        $customers = Customer::whereNull('deleted_at')                    
                    ->where('company_id','=',Auth::user()->company_id)
                    ->orderBy('created_at', 'DESC');
        if(!empty(Input::get('search'))) {           
            $customers = $customers->where(function ($query) {
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
            $customers = $customers->whereBetween('created_at', array($time_from, $time_to));
        }
        $customers = $customers->paginate($this::LIMIT);
        return View('managers.customers.index', compact('customers'));
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

        $customer = new Customer();
        $customer->code = Customer::getCode();
        $customer->name = Input::get('name');
        $customer->email = Input::get('email');
        $customer->address = Input::get('address');
        $customer->phone = Input::get('phone');
        $customer->mobile = Input::get('mobile');
        $customer->birthday = date('Y-m-d', strtotime(Input::get('birthday')));
        $customer->gender = Input::get('gender');
        $customer->cmnd = Input::get('cmnd');
        $customer->mst = Input::get('mst');
        $customer->company_id = Auth()->user()->company_id;
        $customer->status = 1;

        if($customer->save()) {
            return Redirect::route('management.customers')->with('flashSuccess', 'Thêm mới khách hàng thành công!');
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
        $customer = Customer::getCustomerByID($id);

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
        
        $customer->name = Input::get('name');
        $customer->email = Input::get('email');
        $customer->address = Input::get('address');
        $customer->phone = Input::get('phone');
        $customer->mobile = Input::get('mobile');
        $customer->birthday = date('Y-m-d', strtotime(Input::get('birthday')));
        $customer->gender = Input::get('gender');
        $customer->cmnd = Input::get('cmnd');
        $customer->mst = Input::get('mst');

        if($customer->save()) {
            return Redirect::route('management.customers')->with('flashSuccess', 'Cập nhật khách hàng thành công.');
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
            $customer = Customer::getCustomerByID($id);
            if(!empty($customer)) {                
                if($customer->delete()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Khách hàng đã được xóa thành công.'
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
                        'message'=> 'Khách hàng không tồn tại trong hệ thống. Vui lòng thử lại.'
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
        if(Customer::checkExistEmail(Input::get('email'), $company_id)) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * Export a resource.
     * @Author: Vu Nguyen
     * @Created: 07-26-2016
     */
    public function getExport() {        
        $header = array('Mã KH','Họ tên','Email','Giới tính',' Điện thoại','Di động','Địa chỉ','CMND','Ngày sinh');
        $contents = [];
        $customers = Customer::whereNull('deleted_at')                    
                    ->where('company_id','=',Auth::user()->company_id)
                    ->orderBy('created_at', 'DESC')->get();
        foreach ($customers as $key => $customer) {
            $gender = Helper::getGender($customer->gender);
            $contents[] = array($customer->code, $customer->name, $customer->email, 
                        $gender, $customer->phone, $customer->mobile,
                        $customer->address, $customer->cmnd, $customer->birthday);
        }
        Helper::export($header, $contents);
    }
}
