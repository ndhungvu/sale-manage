<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\ManagerController;
use App\Http\Requests;
use App\StockTake;
use App\User;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Library\Helper;


class StockTakeController extends ManagerController
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
            Input::merge(array('status' => -1));

        $stockTakes = StockTake::searchStockTakes($input);
        $stockTakes->appends(\Request::input());
        return View('managers.stock-take.index',compact('stockTakes','staffs','input'));
    }

    public function getCreate(){
    	$currentUserID = Auth::user()->id;
        $staffs = User::getStaffByCompanyID($this->_companyID);
        return View('managers.stock-take.create',compact('currentUserID','staffs'));
    }

    public function postCreate(){
        $save = StockTake::saveStockTake(Input::all());
        if($save){
            return Redirect::route('management.StockTakes')->with('flashSuccess', 'Phiếu kiểm kho đã được cập nhật thành công!');
        }else{
            return Redirect::route('management.StockTakes')->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    public function postDelete($id){
        $stockTake = StockTake::find($id);
        $stockTake->status = StockTake::CANCEL;

        \DB::beginTransaction();
        try {
            $stockTake->save();
            $stockTakeCommodities = $stockTake->getCommodities();

            foreach ($stockTakeCommodities as $stockTakeCommodity) {
                # update on hand for commodity
                \App\BranchCommodity::updateOnHand($stockTakeCommodity->commodity_id,$stockTakeCommodity->on_hand,true);
            }
            \DB::commit();
            \Session::flash('flashSuccess','Hủy phiếu nhập ' .$stockTake->code. ' thành công');
            return \Response::json(['error'=>false,'id'=>$stockTake->id,'message' => 'Hủy phiếu nhập ' .$stockTake->code. ' thành công'], 200);

        } catch (\Exception $e) {
            \DB::rollback();
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$stockTake->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }
    public function getExport() {
        $input = new Input;
        if($input::get('status') == null)
            Input::merge(array('status' => -1));

        $header = array('Mã kiểm kho','Thời gian','Ngày CB kho','Tổng chênh lệch', 'Ghi chú', 'Trạng thái');
        $contents = [];
        
        $stockTakes = StockTake::searchStockTakes($input,false);

        foreach ($stockTakes as $key => $stockTake){
            $contents[] = array($stockTake->code, $stockTake->created_at, $stockTake->balance_date, number_format($stockTake->quantum_diff), $stockTake->note, $stockTake->getStatus());
        }
        Helper::export($header, $contents, 'stocktake_'. date('Y_m_d'));
    }
}