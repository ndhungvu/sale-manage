@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">Hóa đơn</header>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('masters.message')
            </div>
        </div>
        <div class="panel-body" >
            <!--Search-->
            {!! Form::open(array('id'=>'search','method'=>'GET', 'class'=>'form-horizontal filter-form-custom')) !!}
               <div class="form-group">
                    <label for="inputEmail1" class="col-lg-2 control-label">Mã | Tên hóa đơn</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="search" value="{!! !empty($_GET['search']) ? $_GET['search'] : '' !!}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label">Ngày tạo</label>
                    <div class="col-lg-3">
                        <label class="col-lg-4 control-label">Từ ngày</label>
                        <div class="col-lg-8">
                            <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                                <input type="text" size="16" class="form-control" name="time_from" value="{!! !empty($_GET['time_from']) ? $_GET['time_from'] : '' !!}">
                                <span class="input-group-btn add-on">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                          </div>
                        </div>              
                    </div>
                    <div class="col-lg-3">
                        <label class="col-lg-4 control-label">Đến ngày</label>
                        <div class="col-lg-8">
                            <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                                <input type="text" size="16" class="form-control" name="time_to" value="{!! !empty($_GET['time_to']) ? $_GET['time_to'] : '' !!}">
                                <span class="input-group-btn add-on">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            {!! Form::close() !!}  
            <!--End search-->
            @if(!empty($bills))
            <div class="adv-table">
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                    <thead>
                        <tr>
                            <th class="w-100"></th>
                            <th class="w-100">Mã HD</th>
                            <th>Hóa đơn</th>
                            <th>Khách hàng</th>
                            <th>Nhân viên</th>
                            <th>Doanh thu</th>
                            <th>Thời gian</th>                            
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($bills as $key => $bill)
                        <tr class="gradeX old" attr-key-old="<?=$key?>">
                            <td class="center">
                                <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                            </td>
                            <td>{!! $bill->code; !!}</td>
                            <td>{!! $bill->name; !!}</td>
                            <td>{!! $bill->customer->name or 'Khách lẻ'; !!}</td>
                            <td>{!! $bill->staff->name or ''; !!}</td>
                            <td>{!! $bill->total; !!}</td>
                            <td>{!! $bill->sale_date; !!}</td>
                        </tr>
                        <tr class="disabled" attr-key="<?=$key?>">
                            <td class="details" colspan="6">
                                <div class="tab-content js-detail">
                                    <div class="col-lg-12">                                        
                                        <table class="display table table-bordered" id="hidden-table-info">
                                            <thead>
                                                <tr>
                                                    <th class="w-150 center">STT</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Số lượng</th>
                                                    <th>Giá bán</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($bill->bill_sale_commodities))
                                                    <?php $bill_sale_commodities = $bill->bill_sale_commodities; ?>
                                                    @foreach($bill_sale_commodities as $key => $sale_commodity)
                                                    <tr>
                                                        <td class="center">{!! ++ $key !!}</td>
                                                        <td>{!! $sale_commodity->commodity->name or '' !!}</td>
                                                        <td>{!! $sale_commodity->number !!}</td>
                                                        <td>{!! $sale_commodity->sale_money or '' !!}</td>
                                                    </tr>
                                                    @endforeach
                                                @endif                                                    
                                            </tbody>                                                    
                                        </table>                                                                             
                                    </div>
                                </div>
                            </td>   
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else

            @endif
        </div>
    </section>
</div>
@stop