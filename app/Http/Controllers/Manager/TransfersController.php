<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\ManagerController;
use App\Http\Requests;
use App\Transfer;
use App\User;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Library\Helper;


class TransfersController extends ManagerController
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

        if($input::get('type') == null)
            $input::merge(array('type' => -1));

        $transfers = Transfer::searchTransfers($input);
        $transfers->appends(\Request::input());
        return View('managers.transfers.index',compact('transfers','staffs','input'));
    }

    public function getCreate(){
    	$currentUserID = Auth::user()->id;
    	$staffs = User::getStaffByCompanyID($this->_companyID);
        $current_branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $companyBranches = \App\Branch::whereNull('branches.deleted_at')->where(['branches.company_id'=> Auth::user()->company_id, 'branches.status'=>\App\Branch::ACTIVE])->get();
        return View('managers.transfers.create',compact('staffs','currentUserID','companyBranches','current_branch_id'));
    }

    public function postCreate(){
        $save = Transfer::saveTransfer(Input::all());
        if($save){
            return Redirect::route('management.transfers.index')->with('flashSuccess', 'Phiếu chuyển hàng đã được cập nhật thành công!');
        }else{
            return Redirect::route('management.transfers.index')->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    public function postUpdate($id){
        $transfer = Transfer::find($id);
        $transfer->note = Input::get('note');
        if(Input::get('to_branch_id')){
            $transfer->to_branch_id = Input::get('to_branch_id');
        }
        if(Input::get('user_id')){
            $transfer->user_id = Input::get('user_id');
        }
        
        if($transfer->save()){
            \Session::flash('flashSuccess','Phiếu chuyển hàng ' .$transfer->code. '  được cập nhật thành công');
            return \Response::json(['error'=>false,'id'=>$transfer->id,'message' => 'Phiếu chuyển hàng ' .$transfer->code. '  được cập nhật thành công'], 200);
        }else{
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$transfer->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function postDelete($id){
        $transfer = Transfer::find($id);
        $transfer->status = Transfer::CANCEL;
        if($transfer->save()){
            $commodities = \App\TransferCommodity::where(['transfer_commodities.transfer_order_id' => $id])->get();
            if(!empty($commodities)) foreach ($commodities as $commodity) {
                 # update on hand for commodity
                \App\BranchCommodity::updateOnHand($commodity->commodity_id,(0-$commodity->quantum),false,$transfer->to_branch_id);
                \App\BranchCommodity::updateOnHand($commodity->commodity_id,$commodity->quantum,false,$transfer->from_branch_id);
            }
            \Session::flash('flashSuccess','Hủy phiếu chuyển hàng ' .$transfer->code. ' thành công');
            return \Response::json(['error'=>false,'id'=>$transfer->id,'message' => 'Hủy phiếu chuyển hàng ' .$transfer->code. ' thành công'], 200);
        }else{
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$transfer->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function getExport() {
       $input = new Input;
        if($input::get('status') == null)
            $input::merge(array('status' => -1));

        if($input::get('type') == null)
            $input::merge(array('type' => -1));


        $header = array('Mã chuyển hàng','Ngày chuyển','Từ chi nhánh','Tới chi nhánh', 'Giá trị chuyển', 'Trạng thái');
        $contents = [];
        
        $transfers = Transfer::searchTransfers($input,false);

        foreach ($transfers as $key => $transfer){
            $contents[] = array($transfer->code, $transfer->transfer_date, $transfer->getFromBranchName(), $transfer->getToBranchName(), number_format($transfer->total_money), $transfer->getStatus());
        }
        Helper::export($header, $contents, 'transfers_'. date('Y_m_d'));
    }
}