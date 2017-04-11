<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\ManagerController;
use App\Http\Requests;
use App\DamageItem;
use App\Supplier;
use App\User;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Library\Helper;


class DamageItemsController extends ManagerController
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

        $damageItems = DamageItem::searchDamageItems($input);
        $damageItems->appends(\Request::input());
        return View('managers.damage-items.index',compact('damageItems','staffs','input'));
    }

    public function getCreate(){
    	$currentUserID = Auth::user()->id;
    	$staffs = User::getStaffByCompanyID($this->_companyID);
    	return View('managers.damage-items.create',compact('suppliers','staffs','currentUserID'));
    }

    public function postCreate(){
        $save = DamageItem::saveDamageItem(Input::all());
        if($save){
            return Redirect::route('management.damageitems.index')->with('flashSuccess', 'Phiếu xuất hủy đã được cập nhật thành công!');
        }else{
            return Redirect::route('management.damageitems.index')->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    public function postUpdate($id){
        $damageItem = DamageItem::find($id);
        $damageItem->note = Input::get('note');
        if((Input::get('trans_date'))){
            $damageItem->trans_date = Input::get('trans_date');
        }
        $damageItem->user_id = Input::get('user_id');
        if($damageItem->save()){
            \Session::flash('flashSuccess','Phiếu xuất hủy ' .$damageItem->code. '  được cập nhật thành công');
            return \Response::json(['error'=>false,'id'=>$damageItem->id,'message' => 'Hủy phiếu trả nhập hàng' .$damageItem->code. ' thành công'], 200);
        }else{
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$damageItem->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function postDelete($id){
        $damageItem = DamageItem::find($id);
        $damageItem->status = DamageItem::CANCEL;
        \DB::beginTransaction();
        try {
            $damageItem->save();
            $damageItemCommodities = $damageItem->getCommodities();
            foreach ($damageItemCommodities as $damageItemCommodity) {
                # update on hand for commodity
                $num_on_hand = $damageItemCommodity->quantum;
                \App\BranchCommodity::updateOnHand($damageItemCommodity->commodity_id,$num_on_hand);
            }

            \DB::commit();
            \Session::flash('flashSuccess','Hủy phiếu xuất hủy' .$damageItem->code. ' thành công');
            return \Response::json(['error'=>false,'id'=>$damageItem->id,'message' => 'Hủy phiếu xuất hủy' .$damageItem->code. ' thành công'], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            \Session::flash('flashError','Có lỗi không xác định xảy ra, vui lòng reload lại trang.');
            return \Response::json(['error'=>true,'id'=>$damageItem->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function getExport() {
        $input = new Input;
        if($input::get('status') == null)
            $input::merge(array('status' => -1));

        $header = array('Mã trả xuất hủy','Thời gian','Chi nhánh', 'Tổng SL hủy', 'Trạng thái');
        $contents = [];
        
        $damageItems = DamageItem::searchDamageItems($input,false);

        foreach ($damageItems as $key => $damageItem){
            $contents[] = array($damageItem->code, $damageItem->trans_date, $damageItem->getBranchName(), number_format($damageItem->quantum), $damageItem->getStatus());
        }
        Helper::export($header, $contents, 'damage_items_'. date('Y_m_d'));
    }
}