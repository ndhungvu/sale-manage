<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ManagerController;
use Session;
use App\Commodity;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\BillSale;
use App\BillSaleCommodity;
use App\Library\Helper;

use App\Company;
use App\Customer;
use App\BranchCommodity;

class SaleController extends ManagerController
{
    protected $_user;
    protected $_company_id;

    public function __construct()
    {
        parent::__construct();
        $this->_user = Auth::user();
        if(!empty($this->_user)) {
            $this->_company_id = $this->_user->company_id;
        }
    }

    /*
    * Manager sales
    * @Author: Vu Nguyen
    */
    public function getSales() {
        $search = Input::get('search');
        $time_from = Input::get('time_from');
        $time_to = Input::get('time_to');

        $bills =  BillSale::where('company_id', $this->_company_id);    
        if(!empty($search)) {
            $bills = $bills->where(function ($query) use($search) {   
                $query->orWhere('code', 'like', '%'.$search.'%')
                      ->orWhere('name', 'like', '%'.$search.'%');
            });
        }
        if(!empty($time_from) && !empty($time_to)) {
            $bills = $bills->whereBetween('created_at', array($time_from, $time_to));
        }

        if(!empty($branch_id)) {
            $bills = $bills->where('branch_id', $branch_id);
        }
        if(!empty($time_start) && !empty($time_end)) {
            $bills = $bills->whereDate('sale_date', '>=', $time_start)->whereDate('sale_date', '<=', $time_end);
        }
        $bills = $bills->where('status', '=', BillSale::ACTIVE)->whereNull('deleted_at')->with('bill_sale_commodities')->orderBy('created_at', 'desc')->get();
        return View('managers.sales.index',compact('bills'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSale()
    {
        if($this->_user->branch_id != 0){
            /*Get temporary bills of staff */
            $bills = BillSale::tempBillsByUser($this->_user->id);
            if(count($bills) == 0) {
                $bill = new BillSale();
                $bill->name = 'TEMP'.$this->_user->id;
                $bill->code = BillSale::getTempCode();
                $bill->user_id = $this->_user->id;
                $bill->company_id = $this->_user->company_id;
                $bill->branch_id = $this->_user->branch_id;
                $bill->status = BillSale::TEMP;
                $bill->sale_date = date('Y-m-d H:i:s');
                if($bill->save()) {
                    $bills[] = BillSale::getBillSaleByID($bill->id);
                }
            }
            $params = new Input;
            $pricebooks = \App\PriceBook::getForSale();
        	/*Get products*/
        	$products = BranchCommodity::getPublishProductsByBranch($this->_user->branch_id, $params);
            //dd($products);
            return View('managers.sale',compact('products','bills', 'customers','pricebooks','params'));
        }
        return Redirect::route('management.dashboard');
    }

    public function postSale()
    {
        $id = Input::get('bill_id');
        $bill = BillSale::getBillSaleByID($id);
        if(!empty($bill)) {
            $numbers = Input::get('number');
            /*Get bill sale commodities*/
            $bill_sale_commodities = BillSaleCommodity::getTempBills($id);
            foreach ($bill_sale_commodities as $key => $bill_sale_commodity) {
                $bill_sale_commodity->number = $numbers[$key];
                $bill_sale_commodity->save();
            }

            $base_price_total = 0;
            $bill_sale_commodities = $bill->bill_sale_commodities;
            if(!empty($bill_sale_commodities)) {
                foreach ($bill_sale_commodities as $key => $bill_sale_commodity) {
                    $base_price_total = $base_price_total + $bill_sale_commodity->commodity->last_price;
                }
            }
            /*Save bill*/
            $bill->name = 'HDBH_'.$this->_user->name;
            $bill->code = BillSale::getCode();
            $bill->status = BillSale::ACTIVE;
            $bill->sale_date = date('Y-m-d H:i:s');
            $bill->total = Helper::thousandSeparator(Input::get('total'));
            $bill->discount = Helper::thousandSeparator(Input::get('discount'));
            $bill->pay = Helper::thousandSeparator(Input::get('pay'));
            $bill->base_price_total = $base_price_total;
            $bill->customer_id = Input::get('customer_id');
            $bill->note = Input::get('note');
            if($bill->save()) {
                $product_ids = Input::get('product_id');
                $price_bases = Input::get('price_base');
                
                /*Update product*/
                for($i = 0; $i < count($product_ids); $i++) {
                    $branchCommodity = BranchCommodity::getBranchCommodity($this->_user->branch_id, $product_ids[$i]);
                    $branchCommodity->on_hand = $branchCommodity->on_hand - $numbers[$i];
                    $branchCommodity->save();
                }
                return Redirect::route('sale.print', $bill->id)->with('flashSuccess', 'Bán hàng thành công!');
                //return Redirect::route('sale')->with('flashSuccess', 'Bán hàng thành công!');
            }
            
        }
    }

    public function getSalePrint($id) {
        $bill = BillSale::getBillSaleByID($id);
        return View('managers.sale-print',compact('bill'));
    }

    public function getFramePrint($id) {
        $bill = BillSale::getBillSaleByID($id);
        return View('managers.frame-print',compact('bill'));
    }

    public function getProduct($bill_id, $id) {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
             /*Get product*/
            //$product = Commodity::getPublishProductByID($id);
            $product = BranchCommodity::getBranchCommodity($this->_user->branch_id, $id);
            if(!empty($product)) {
                if($product->on_hand > 0) {
                    /*Save bill sale product tmp*/
                    $bill_sale_commodity = BillSaleCommodity::tempCommodityByBillID($bill_id, $id);
                    if(!empty($bill_sale_commodity)) {
                        $bill_sale_commodity->number = $bill_sale_commodity->number + 1;
                    }else {
                        $bill_sale_commodity = new BillSaleCommodity();
                        $bill_sale_commodity->bill_sale_id = $bill_id;
                        $bill_sale_commodity->commodity_id = $product->commodity_id;

                        $price = !empty($_GET['book']) ? $product->commodity->price_quote : $product->commodity->base_price;
                       
                        $bill_sale_commodity->sale_money = $price;
                        $bill_sale_commodity->number = 1;                    
                    }
                    if($bill_sale_commodity->save()) {
                        return response()->json([
                            'status' => true,
                            'data'=> $product
                        ]);
                    }       
                }else {
                    return response()->json([
                        'status' => true,
                        'message'=> 'Sản phẩm hết hàng trong hệ thống.'
                    ], 200);
                }                          
            }else {
                return response()->json([
                        'status' => false,
                        'message'=> 'Sản phẩm không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 200);
            }
        }
    }

    public function getDownProduct($bill_id, $id) {       
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
             /*Get product*/
            $product = Commodity::getPublishProductByID($id);
            if(!empty($product)) {
                /*Save bill sale product tmp*/
                $bill_sale_commodity = BillSaleCommodity::tempCommodityByBillID($bill_id, $id);
                if(!empty($bill_sale_commodity)) {
                    $bill_sale_commodity->number = $bill_sale_commodity->number - 1;
                }
                if($bill_sale_commodity->save()) {
                    return response()->json([
                        'status' => true,
                        'data'=> $product
                    ]);
                }                
            }else {
                return response()->json([
                        'status' => false,
                        'message'=> 'Sản phẩm không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 200);
            }
        }
    }

    public function getRemoveProduct($bill_id, $id, $number) {       
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
             /*Get product*/
            $product = Commodity::getPublishProductByID($id);
            if(!empty($product)) {
                /*Save bill sale product tmp*/
                $bill_sale_commodity = BillSaleCommodity::tempCommodityByBillID($bill_id, $id);
                $price = $bill_sale_commodity->sale_money* $bill_sale_commodity->number;
                if($bill_sale_commodity->delete()) {
                    return response()->json([
                        'status' => true,
                        'price'=>$price
                    ]);
                }                
            }else {
                return response()->json([
                        'status' => false,
                        'message'=> 'Sản phẩm không tồn tại trong hệ thống. Vui lòng thử lại.'
                    ], 200);
            }
        }
    }

    public function ajax_products() {       
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            /*Get products*/
            /*$products = Commodity::select('id','name')
                ->where('status', Commodity::ACTIVE_STATUS)
                ->where('company_id','=', $this->_user->company_id)
                ->whereNull('deleted_at')->get();*/
            $products = BranchCommodity::getPublishProductsByBranch($this->_user->branch_id);
            $prods = [];
            foreach ($products as $key => $product) {
                $prods[$key]['id'] = $product->commodity->id;
                $prods[$key]['name'] = $product->commodity->name;
            }
            if(!empty($products)) {
                return response()->json([
                        'status' => true,
                        'data'=> $prods
                    ]);
            }
        }
    }

    public function ajax_customers() {       
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            /*Get customers*/
            $customers = Customer::select('id','name')
                ->where('company_id','=', $this->_user->company_id)
                ->whereNull('deleted_at')->get();
            if(!empty($customers)) {
                return response()->json([
                        'status' => true,
                        'data'=> $customers
                    ]);
            }
        }
    }

    public function getCreateBill() {       
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            /*Get temporary bills of staff */
            $bill = new BillSale();
            $bill->name = 'TEMP'.$this->_user->id;
            $bill->code = BillSale::getTempCode();
            $bill->user_id = $this->_user->id;
            $bill->company_id = $this->_user->company_id;
            $bill->branch_id = $this->_user->branch_id;
            $bill->status = BillSale::TEMP;
            $bill->sale_date = date('Y-m-d H:i:s');
            if($bill->save()) {
                return response()->json([
                    'status' => true,
                    'data' => $bill
                ]);
            }else {
                return response()->json([
                        'status' => false,
                        'message'=> 'Lỗi hệ thống, vui lòng thử lại.'
                    ], 200);
            }
        }
    }

    public function getDeleteBill($id) {       
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $bill_sale = BillSale::getBillSaleByID($id);
            if(!empty($bill_sale)) {
                $bill_sale_commodities = $bill_sale->bill_sale_commodities;
                if($bill_sale->delete()) {
                    if(isset($bill_sale_commodities)) {
                        $bill_sale_commodities->each(function ($bill_sale_commodity, $key) {
                            $bill_sale_commodity->delete();
                        });
                    }
                    return response()->json([
                        'status' => true,
                        'message'=> 'Xóa hóa đơn thành công.'
                    ]);
                }
            }else {
                return response()->json([
                    'status' => false,
                    'message'=> 'Không tìm thấy hóa đơn.'
                ], 200);
            }
        }
    }
    
}
