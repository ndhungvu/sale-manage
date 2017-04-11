<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\ManagerController;
use App\Http\Requests;
use App\PurchaseReturn;
use App\PurchaseReturnCommodity;
use App\Supplier;
use App\User;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Library\Helper;


class PurchaseReturnController extends ManagerController
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

        $purchaseReturns = PurchaseReturn::searchPurchaseReturns($input);
        $purchaseReturns->appends(\Request::input());
        return View('managers.purchase-return.index',compact('purchaseReturns','staffs','input'));
    }

    public function getCreate(){
    	$currentUserID = Auth::user()->id;
    	$suppliers = Supplier::getByCompanyID($this->_companyID);
    	$staffs = User::getStaffByCompanyID($this->_companyID);
    	return View('managers.purchase-return.create',compact('suppliers','staffs','currentUserID'));
    }

    public function postCreate(){
        $save = PurchaseReturn::savePurchaseReturn(Input::all());
        if($save){
            return Redirect::route('management.purchasereturn.index')->with('flashSuccess', 'Phiếu trả nhập hàng đã được cập nhật thành công!');
        }else{
            return Redirect::route('management.purchasereturn.index')->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    public function postUpdate($id){
        $purchaseReturn = PurchaseReturn::find($id);
        $purchaseReturn->note = Input::get('note');
        if((Input::get('return_date'))){
            $purchaseReturn->return_date = Input::get('return_date');
        }
        $purchaseReturn->user_id = Input::get('user_id');
        if($purchaseReturn->save()){
            \Session::flash('flashSuccess','Phiếu trả nhập hàng ' .$purchaseReturn->code. '  được cập nhật thành công');
            return \Response::json(['error'=>false,'id'=>$purchaseReturn->id,'message' => 'Hủy phiếu trả nhập hàng' .$purchaseReturn->code. ' thành công'], 200);
        }else{
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$purchaseReturn->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function postDelete($id){
        $purchaseReturn = PurchaseReturn::find($id);
        $purchaseReturn->status = PurchaseReturn::CANCEL;
        \DB::beginTransaction();
        try {
            $purchaseReturn->save();
            $purchaseReturnCommodities = $purchaseReturn->getCommodities();
            foreach ($purchaseReturnCommodities as $purchaseReturnCommodity) {
                # update on hand for commodity
                $num_on_hand = $purchaseReturnCommodity->quantum;
                \App\BranchCommodity::updateOnHand($purchaseReturnCommodity->commodity_id,$num_on_hand);
            }

            \DB::commit();
            \Session::flash('flashSuccess','Hủy phiếu trả nhập hàng' .$purchaseReturn->code. ' thành công');
            return \Response::json(['error'=>false,'id'=>$purchaseReturn->id,'message' => 'Hủy phiếu trả nhập hàng' .$purchaseReturn->code. ' thành công'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$purchaseReturn->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function getExport() {
        $input = new Input;
        if($input::get('status') == null)
            Input::merge(array('status' => -1));

        $header = array('Mã trả hàng nhập','Thời gian','Nhà cung cấp','Chi nhánh', 'Tổng cộng', 'Trạng thái');
        $contents = [];
        
        $purchaseReturns = PurchaseReturn::searchPurchaseReturns($input,false);

        foreach ($purchaseReturns as $key => $purchaseReturn){
            $contents[] = array($purchaseReturn->code, $purchaseReturn->return_date, $purchaseReturn->getSupplierName(), $purchaseReturn->getBranchName(), number_format($purchaseReturn->total_money), $purchaseReturn->getStatus());
        }
        Helper::export($header, $contents, 'purchase_return_'. date('Y_m_d'));
    }
}