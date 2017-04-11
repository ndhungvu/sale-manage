<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\ManagerController;
use App\Http\Requests;
use App\Commodity;
use App\CommodityGroup;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use App\Library\Helper;


class CommoditiesController extends ManagerController
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function searchProducts(){
        $key = Input::get('q');
        $branch_id = (!is_null(session('current_branch'))) ? session('current_branch') : 0;
        $products = \DB::table('commodities')
            ->leftJoin('branch_commodities', function($join) use ($branch_id){
                    $join->on('commodities.id', '=', 'branch_commodities.commodity_id');
                    $join->where('branch_commodities.branch_id', '=', $branch_id);
            })
            ->select('commodities.id', 'commodities.name', 'commodities.code', 'commodities.cost', 'commodities.last_price', 'commodities.base_price', \DB::raw('IFNULL(branch_commodities.on_hand, 0) as on_hand'))
            ->whereNull('commodities.deleted_at')->where(['commodities.company_id'=>$this->_companyID, 'commodities.status'=>Commodity::ACTIVE_STATUS])
            ->where(function ($query) {
                $key = Input::get('q');
                $query->orWhere('commodities.name', 'like', "{$key}%")
                      ->orWhere('commodities.code', 'like', "{$key}%");
            })
            ->orderBy('commodities.created_at', 'desc')
            ->limit(10)
            ->get();

        return \Response::json($products, 200);
    }

    public function getProducts()
    {
        $sampleFileLink = \Request::root() . "/assets/templates/MauFileSanPham.xlsx";
        $addMore = Input::get('more');
        $categories = CommodityGroup::getCategoryByCompany($this->_companyID);
        $categorienames = CommodityGroup::getCategoryByCompany($this->_companyID,true);
        $params = new Input;
        $products = Commodity::getProducts($params);
        $products->appends(\Request::input());
        return View('managers.commodities.products',compact('sampleFileLink','categories','products','addMore','categorienames','params'));
    }

    public function getExport() {
        $params = new Input;
        $header = array('Mã hàng','Nhóm hàng(3 Cấp)','Tên hàng hóa','Giá bán', 'Giá vốn', 'Tồn kho', 'Tồn nhỏ nhất', 'Tồn lớn nhất', 'ĐVT', 'Hình ảnh');
        $contents = [];
        
        $products = Commodity::getProducts($params);
        $categorienames = CommodityGroup::getCategoryByCompany($this->_companyID,true);

        foreach ($products as $key => $product){
            $contents[] = array($product->code, $product->getCategoryNameFromArrCategories($categorienames), $product->name, $product->base_price, $product->cost, $product->getOnHand(), $product->min_quantity, $product->max_quantity, $product->dvt, $product->getImage());
        }
        Helper::export($header, $contents, 'products_'. date('Y_m_d'));
    }

    public function importProduct(){
        ini_set('max_execution_time', 6000);
        set_time_limit(0);
        ini_set("memory_limit", -1);
        if(!empty($_FILES['file_import']['name']) && ($_FILES['file_import']['type'] == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $_FILES['file_import']['type'] == 'application/vnd.ms-excel')){
            if (($handle = fopen($_FILES['file_import']['tmp_name'], "r")) !== FALSE) {
                \Excel::load($_FILES['file_import']['tmp_name'], function($reader) {
                    $arrDatas = $reader->toArray();
                    $countProduct = count($arrDatas);
                    Commodity::importData($arrDatas,$this->_companyID);
                    \Session::flash('flashSuccess',"Đã import hàng hóa từ file thành công, đã cập nhật {$countProduct} mặt hàng");
                });
                fclose($handle);
            }else{
                \Session::flash('flashError',"Lỗi không xác định, vui lòng thử lại.");
            }
        }else{
            \Session::flash('flashError',"Bạn vui lòng chọn một file dữ liệu mẫu, chỉ hỗ trợ đuôi: xlsx, xls.");
        }
        echo json_encode(['error' => false]);
        //return Redirect::route('management.products');
    }

    public function postProduct(){
        $validator = Validator::make(Input::all(), Commodity::$rules, Commodity::$message);
        $validator->setAttributeNames(Commodity::$attributeNames);

        $validator->after(function($validator) {
            if(Input::get('code') != ''){
                $proc = Commodity::where(['code' => Input::get('code'), 'company_id' => $this->_companyID])->first();
                if($proc){
                    $validator->errors()->add('code', 'Mã hàng hóa đã tồn tại trong hệ thống, bạn phải nhập một Mã hàng hóa khác.');
                }
            }
        });

        if ($validator->fails()) {
            $messages = $validator->messages();
            if(\Request::ajax()){
                return \Response::json(['error' => true, 'errors' => $messages, 'message' => $this->getErrorMessage($messages)], 200);
            }else{
                return Redirect::route('management.products')->withErrors($validator);
            }
        }
        if(\Request::ajax()){
            return \Response::json(['error'=>false], 200);
        }else{
            $dataSave = Input::all();
            $dataSave['company_id'] = $this->_companyID;
            $save = Commodity::saveProducts($dataSave);
            if(Input::get('formType') == 0)
                return Redirect::route('management.products')->with('flashSuccess', 'Thêm mới hàng hóa thành công!');
            else
                return Redirect::route('management.products',['more'=>1])->with('flashSuccess', 'Thêm mới hàng hóa thành công!');
        }
    }

    public function getUpdate($id){
        $model = Commodity::findOrFail($id);
        $categories = CommodityGroup::getCategoryByCompany($this->_companyID);
        return View('managers.commodities.updateproduct',compact('model','categories','id'));
    }

    public function postUpdate($id){
        $model = Commodity::findOrFail($id);

        $rules = Commodity::$rules;
        //$rules['code'] =  "unique:commodities,code,{$model->id}";
        $validator = Validator::make(Input::all(), $rules, Commodity::$message);
        $validator->setAttributeNames(Commodity::$attributeNames);

        $validator->after(function($validator) use ($id) {
            if(Input::get('code') != ''){
                $proc = Commodity::where(['code' => Input::get('code'), 'company_id' => $this->_companyID])->where('id','!=', $id)->first();
                if($proc){
                    $validator->errors()->add('code', 'Mã hàng hóa đã tồn tại trong hệ thống, bạn phải nhập một Mã hàng hóa khác.');
                }
            }
        });

        if ($validator->fails()) {
            $messages = $validator->messages();
            if(\Request::ajax()){
                return \Response::json(['error' => true, 'errors' => $messages, 'message' => $this->getErrorMessage($messages)], 200);
            }else{
                return Redirect::route('management.products')->withErrors($validator);
            }
        }
        if(\Request::ajax()){
            return \Response::json(['error'=>false], 200);
        }else{
            $save = Commodity::saveProducts(Input::all(),$model);
            return Redirect::route('management.products')->with('flashSuccess', 'Cập nhật hàng hóa thành công!');
        }
    }

    public function postUpdateStatus($id){
        $model = Commodity::findOrFail($id);
        if(Input::get('action') == 'inactive'){
            $model->status = Commodity::INACTIVE_STATUS;
        }else{
            $model->status = Commodity::ACTIVE_STATUS;
        }
        $model->save();
        return \Response::json(['error'=>false,'id'=>$model->id,'message' => 'Cập nhật thông tin hàng hóa thành công'], 200);
    }

    public function postDelete($id){
        $model = Commodity::findOrFail($id);
        if($model->delete()){
            return \Response::json(['error'=>false,'id'=>$model->id,'message' => 'Xóa hàng hóa thành công'], 200);
        }else{
            return \Response::json(['error'=>true,'id'=>$model->id,'message' => 'Có lỗi không xác định xảy ra, vui lòng reload lại trang'], 200);
        }
    }

    public function getPriceBook(){
        $categories = CommodityGroup::getCategoryByCompany($this->_companyID);
        $categorienames = CommodityGroup::getCategoryByCompany($this->_companyID,true);
        $params = new Input;
        $pricebooks = \App\PriceBook::getAll();
        $products = \App\PriceBook::getProducts($params);
        $products->appends(\Request::input());
        $arrPriceBooks = $pricebooks->keyBy('id')->toArray('id');
        $pricebookname = 'Bảng giá chung';
        $pricebookid = '';
        if($params::get('book')){
            $pricebookname = $arrPriceBooks[$params::get('book')]['name'];
            $pricebookid = $params::get('book');
        }
        return View('managers.commodities.pricebook',compact('pricebookid','pricebookname','pricebooks','categories','products','categorienames','params'));
    }

    public function createPriceBook(){
        $validator = Validator::make(Input::all(), \App\PriceBook::$rules, \App\PriceBook::$message);
        $validator->setAttributeNames(\App\PriceBook::$attributeNames);
        if ($validator->fails()) {
            $messages = $validator->messages();
            if(\Request::ajax()){
                return \Response::json(['error' => true, 'errors' => $messages, 'message' => $this->getErrorMessage($messages)], 200);
            }else{
                return Redirect::route('management.products')->withErrors($validator);
            }
        }
        if(\Request::ajax()){
            return \Response::json(['error'=>false], 200);
        }else{
            $dataSave = Input::all();
            $dataSave['company_id'] = $this->_companyID;
            $dataSave['user_id'] = \Auth::user()->id;
            $save = \App\PriceBook::savePriceBook($dataSave);
            if($save){
                //dump($save);die();
                return Redirect::route('management.PriceBook',['book'=>$save->id])->with('flashSuccess', 'Thêm mới bảng giá thành công!');
            }else{
                return Redirect::route('management.PriceBook')->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
            }
        }
    }

    public function ajaxPriceBook($id){
        $pricebook = \App\PriceBook::where(['id' => $id])->first();
        if (\Request::isMethod('post'))
        {
            if(Input::get('delete')){
                $pricebook->delete();
                \Session::flash('flashSuccess','Xóa dữ liệu thành công');
                return \Response::json(['error'=>false,'id'=>$pricebook->id], 200);
            }

            $validator = Validator::make(Input::all(), \App\PriceBook::$rules, \App\PriceBook::$message);
            $validator->setAttributeNames(\App\PriceBook::$attributeNames);
            if ($validator->fails()) {
                $messages = $validator->messages();
                return \Response::json(['error' => true, 'errors' => $messages, 'message' => $this->getErrorMessage($messages)], 200);
            }
            $dataSave = Input::all();
            $dataSave['company_id'] = $this->_companyID;
            $dataSave['user_id'] = \Auth::user()->id;
            $save = \App\PriceBook::savePriceBook($dataSave, $pricebook);
            \Session::flash('flashSuccess',"Bảng giá '{$pricebook->name}'' đã được cập nhật thành công!");
            return \Response::json(['error'=>false,'id'=>$pricebook->id,'message' => "Bảng giá '{$pricebook->name}'' đã được cập nhật thành công!"], 200);
        }
        return View('managers.commodities.updatepricebook',compact('pricebook'));
    }

    public function postUpdatePrice($id){
        $new_price = trim(Input::get('new_price'));
        $book = trim(Input::get('pricebook'));
        if($book == '' || $book == null){
            $model = Commodity::findOrFail($id);
            $model->base_price = $new_price;
        }else{
            $model = \App\PriceBookCommodity::where(['commodity_id' => $id, 'price_book_id' => $book])->first();
            if($model == null){
                $model = new \App\PriceBookCommodity;
                $model->price_book_id = $book;
                $model->commodity_id = $id;
                $model->company_id = $this->_companyID;
            }
            $model->base_book_price = $new_price;
        }
        
        if($model->save()){
            return \Response::json(['error'=>false,'id'=>$model->id,'message' => 'Cập nhật thông tin hàng hóa '.$model->code.' thành công'], 200);
        }else{
            return \Response::json(['error'=>true,'id'=>$model->id,'message' => 'Lỗi hệ thống, vui lòng thử lại!'], 200);
        }
    }

    public function delproductPriceBook($id,$pricebook){
        \Session::flash('flashSuccess','Xóa dữ liệu thành công');
        return \App\PriceBookCommodity::where(['price_book_id' => $pricebook, 'commodity_id' => $id])->delete();
    }

    public function getExportPriceBook() {
        $params = new Input;    
        $header = array('Mã hàng','Tên hàng hóa','Giá thiết lập');
        $contents = [];
        
        $products = \App\PriceBook::getProducts($params,false);

        foreach ($products as $key => $product){
            $contents[] = array($product->code, $product->name, $product->getPriceBook());
        }
        Helper::export($header, $contents, 'pricebook_'. date('Y_m_d'));
    }

    public function getProductGroups() {
        $groups = CommodityGroup::whereNull('deleted_at')                    
                    ->where('company_id','=',$this->_companyID)
                    ->where('parent_id','=',0)
                    ->orderBy('created_at', 'DESC')->paginate($this::LIMIT);

        $categories = CommodityGroup::getCategoryByCompany($this->_companyID);
        return View('managers.commodities.groups', compact('groups','categories'));
    }

    /**
     * Creating a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postCreateGroup()
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

        $group = new CommodityGroup();        
        $group->name = Input::get('name');
        $group->parent_id = Input::get('parent_id');
        $group->company_id = $this->_companyID;
        $group->status = 1;

        if($group->save()) {
            return Redirect::route('management.products.groups')->with('flashSuccess', 'Thêm mới nhóm hàng thành công!');
        }else {
            return Redirect::back()->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

    /**
     * Creating a new resource.
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function postEditGroup($id)
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

        $group = CommodityGroup::getCommodityGroupByID($id);
        $group->name = Input::get('name');
        $group->parent_id = Input::get('parent_id');

        if($group->save()) {
            return Redirect::route('management.products.groups')->with('flashSuccess', 'Cập nhật nhóm hàng thành công!');
        }else {
            return Redirect::back()->with('flashError', 'Lỗi hệ thống, vui lòng thử lại!');
        }
    }

     /**
     * Delete a resource.
     * @Author: Vu Nguyen
     * @Created: 04-12-2015
     */
    public function postDeleteGroup($id) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $group = CommodityGroup::getCommodityGroupByID($id);
            if(!empty($group)) {                
                if($group->delete()) {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Nhóm hàng đã được xóa thành công.'
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
                        'message'=> 'Nhóm hàng không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 500);
            }
        }
    }

}
