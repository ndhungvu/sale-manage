<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\ManagerController;
use App\Http\Requests;
use App\PurchaseOrder;
use App\Supplier;
use App\User;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Library\Helper;


class PurchaseOrderController extends ManagerController
{
	CONST LIMIT = 10;
    protected $_companyID;

    public function __construct()
    {
        parent::__construct();
        $this->_companyID = $this->getCurrentCompany();
    }

    public function getCurrentCompany(){
        if (Auth::check()) {
            return Auth::user()->company_id;
        }
    }

    public function index()
    {
        $staffs = User::getStaffByCompanyID($this->_companyID);
        $input = new Input;
        if($input::get('status') == null)
            $input::merge(array('status' => -1));

        $purchaseorders = PurchaseOrder::searchPurchaseOrders($input);
        $purchaseorders->appends(\Request::input());
        return View('managers.purchase-order.index',compact('purchaseorders','staffs','input'));
    }

    public function getCreate(){
    	$currentUserID = Auth::user()->id;
    	$suppliers = Supplier::getByCompanyID($this->_companyID);
    	$staffs = User::getStaffByCompanyID($this->_companyID);
    	return View('managers.purchase-order.create',compact('suppliers','staffs','currentUserID'));
    }

    public function postCreate(){
        $save = PurchaseOrder::savePurchaseOrder(Input::all());
        if($save){
            return Redirect::route('management.purchaseorder.index')->with('flashSuccess', 'Phiếu nhập hàng đã được cập nhật thành công!');
        }else{
            return Redirect::route('management.purchaseorder.index')->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    public function postUpdate($id){
        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrder->note = Input::get('note');
        if(Input::get('purchase_date')){
            $purchaseOrder->purchase_date = Input::get('purchase_date');
        }
        $purchaseOrder->user_id = Input::get('user_id');
        if($purchaseOrder->save()){
            \Session::flash('flashSuccess','Phiếu nhập hàng ' .$purchaseOrder->code. '  được cập nhật thành công');
            return \Response::json(['error'=>false,'id'=>$purchaseOrder->id,'message' => 'Hủy phiếu nhập ' .$purchaseOrder->code. ' thành công'], 200);
        }else{
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$purchaseOrder->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function postDelete($id){
        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrder->status = PurchaseOrder::CANCEL;
        if($purchaseOrder->save()){
            \Session::flash('flashSuccess','Hủy phiếu nhập ' .$purchaseOrder->code. ' thành công');
            return \Response::json(['error'=>false,'id'=>$purchaseOrder->id,'message' => 'Hủy phiếu nhập ' .$purchaseOrder->code. ' thành công'], 200);
        }else{
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$purchaseOrder->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function getExport() {
        $input = new Input;
        if($input::get('status') == null)
            Input::merge(array('status' => -1));

        $header = array('Mã nhập hàng','Thời gian','Nhà cung cấp','Chi nhánh', 'Tổng cộng', 'Trạng thái');
        $contents = [];
        
        $purchaseorders = PurchaseOrder::searchPurchaseOrders($input,false);

        foreach ($purchaseorders as $key => $purchaseorder){
            $contents[] = array($purchaseorder->code, $purchaseorder->purchase_date, $purchaseorder->getSupplierName(), $purchaseorder->getBranchName(), number_format($purchaseorder->total_money), $purchaseorder->getStatus());
        }
        Helper::export($header, $contents, 'purchase_order_'. date('Y_m_d'));
    }
}