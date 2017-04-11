<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ManagerController;
use App\User;
use App\Branch;
use App\Library\Helper;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Hash;
use App\Company;
use App\BillSale;


class ReportsController extends ManagerController
{
    CONST LIMIT = 10;
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
    /**
     * Display reports staff
     * @Author: Vu Nguyen
     * @Created: 03-12-2015
     */
    public function getEndDay()
    {   
        $branch_id = Input::get('branch_id');
        $company = Company::getCompanyByID($this->_company_id);
        $time_start = date('Y-m-d 00:00:00');
        $time_end = date('Y-m-d 23:59:59');
        $bill_sales = [];
        $report_bill_sales = BillSale::getReportBillSales($this->_company_id, $branch_id, $time_start, $time_end);
        if(!empty($report_bill_sales)) {
            foreach ($report_bill_sales as $key => $report) {
                $bill_sales[$key]['report_time'] = $report;
                $bill_sales[$key]['bills'] = BillSale::getBillSales($this->_company_id, $branch_id, $report->sale_date);
            }
        }
        return View('managers.reports.endday',compact('company','bill_sales'));
    }

    public function getSale()
    {   
        $branch_id = Input::get('branch_id');
        $company = Company::getCompanyByID($this->_company_id);
        $time_start = !empty(Input::get('time_start')) ? date('Y-m-d',strtotime(Input::get('time_start'))) : date('Y-m-01');
        $time_end = !empty(Input::get('time_end')) ? date('Y-m-d',strtotime(Input::get('time_end'))) : date("Y-m-t");
        $bill_sales = [];
        $report_bill_sales = BillSale::getReportBillSales($this->_company_id, $branch_id, $time_start, $time_end);
        if(!empty($report_bill_sales)) {
            foreach ($report_bill_sales as $key => $report) {
                $bill_sales[$key]['report_time'] = $report;
                $bill_sales[$key]['bills'] = BillSale::getBillSales($this->_company_id, $branch_id, $report->sale_date);
            }
        }
        return View('managers.reports.sale',compact('company','bill_sales'));
    }

    public function getOrder()
    {   
        return View('managers.reports.order');
    }
    public function getProduct()
    {   
        return View('managers.reports.product');
    }
    public function getCustomer()
    {   
        $branch_id = Input::get('branch_id');
        $company = Company::getCompanyByID($this->_company_id);
        $time_start = !empty(Input::get('time_start')) ? date('Y-m-d',strtotime(Input::get('time_start'))) : date('Y-m-01');
        $time_end = !empty(Input::get('time_end')) ? date('Y-m-d',strtotime(Input::get('time_end'))) : date("Y-m-t");
        $bill_sales = [];
        $report_bill_sales = BillSale::getReportBillSalesByCustomer($this->_company_id, $branch_id, $time_start, $time_end);
        if(!empty($report_bill_sales)) {
            foreach ($report_bill_sales as $key => $report) {
                $bill_sales[$key]['report_time'] = $report;
                $bill_sales[$key]['bills'] = BillSale::getBillSales($this->_company_id, $branch_id, $report->sale_date, $report->customer_id);
            }
        }
        //dd($bill_sales);
        return View('managers.reports.customer',compact('company','bill_sales'));
    }
    public function getSupplier()
    {   
        return View('managers.reports.supplier');
    }
    public function getStaff()
    {   
        $branch_id = Input::get('branch_id');
        $company = Company::getCompanyByID($this->_company_id);
        $time_start = !empty(Input::get('time_start')) ? date('Y-m-d',strtotime(Input::get('time_start'))) : date('Y-m-01');
        $time_end = !empty(Input::get('time_end')) ? date('Y-m-d',strtotime(Input::get('time_end'))) : date("Y-m-t");
        $bill_sales = [];
        $report_bill_sales = BillSale::getReportBillSalesByStaff($this->_company_id, $branch_id, $time_start, $time_end);
        if(!empty($report_bill_sales)) {
            foreach ($report_bill_sales as $key => $report) {
                $bill_sales[$key]['report_time'] = $report;
                $bill_sales[$key]['bills'] = BillSale::getBillSales($this->_company_id, $branch_id, $report->sale_date);
            }
        }
        return View('managers.reports.staff',compact('company','bill_sales'));
    }
    public function getFinancial()
    {   
        $branch_id = Input::get('branch_id');
        $company = Company::getCompanyByID($this->_company_id);
        $sort_time = !empty(Input::get('sort_time')) ? Input::get('sort_time') : 'm';
        $bill_sales = [];

        switch ($sort_time) {
            case 'm':
                $report_bill_sales = BillSale::getReportBillSalesMonth($this->_company_id, $branch_id);
                break;
            case 'q':
                $report_bill_sales = BillSale::getReportBillSalesByQuarter($this->_company_id, $branch_id);
                break;
            case 'y':
                $report_bill_sales = BillSale::getReportBillSalesByYear($this->_company_id, $branch_id);
                break;
        }
        if(!empty($report_bill_sales)) {
            foreach ($report_bill_sales as $key => $report) {
                $bill_sales[$key]['report_time'] = $report;
                $bill_sales[$key]['bills'] = BillSale::getBillSales($this->_company_id, $branch_id, $report->sale_date);
            }
        }
        return View('managers.reports.financial.'.$sort_time, compact('company','bill_sales'));
    }
}
