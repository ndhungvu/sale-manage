@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
    <div class="col-lg-3">
        <section class="panel">            
            {!! Form::open(array('id'=>'search','method'=>'GET')) !!}            
            <div class="panel-body" >
                <header class="panel-heading jsPannel">
                    Kiểu hiển thị
                </header>
                <div class="form-group">
                    <div class="radios">
                        <label class="label_radio" for="graph">
                            <input name="display" id="radio" class="jsRadioDisplay" value="graph" type="radio" {!! empty($_GET['display']) || $_GET['display'] == 'graph' ? 'checked' : '' !!}> Biểu đồ
                        </label>
                        <label class="label_radio" for="table">
                            <input name="display" id="radio" class="jsRadioDisplay" value="table" type="radio" {!! !empty($_GET['display']) && $_GET['display'] == 'table' ? 'checked' : '' !!}> Báo cáo
                        </label>                         
                    </div>
                </div>                
            </div>
            <div class="panel-body" >
                <header class="panel-heading jsPannel">
                    Chi nhánh
                </header>
                <div class="form-group">
                    <br>
                    <select name="branch_id" class="form-control m-bot15">
                        <option value="">---Tất cả---</option>
                        @if(!empty($company))
                            <?php $branchs = $company->branches;?>                            
                            @foreach($branchs as $branch)
                            <option value="{!! $branch->id !!}" {!! !empty($_GET['branch_id']) && $branch->id == $_GET['branch_id'] ? 'selected' : '' !!}>{!! $branch->name !!}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="panel-body" >
                <header class="panel-heading jsPannel">
                    Thời gian
                </header>
                <div class="form-group">
                    <br>
                    <div class="input-group input-large" data-date-format="dd/mm/yyyy">
                        <span class="input-group-addon">Từ</span>
                        <input type="text" class="form-control dpd1" name="time_start" value="{!! !empty($_GET['time_start']) ? $_GET['time_start'] : date('m/01/Y')!!}">
                        <span class="input-group-addon">Đến</span>
                        <input type="text" class="form-control dpd2" name="time_end" value="{!! !empty($_GET['time_end']) ? $_GET['time_end'] : date('m/t/Y')!!}">
                    </div>
                </div>
            </div>
            <div class="panel-body" >
                <div class="form-group right">
                    <button class="btn btn-primary jsSubmit"><i class="fa fa-search"></i>Tìm kiếm</button>
                </div>
            </div>            
            {!! Form::close() !!}
        </section>
    </div>
    <div class="col-lg-9">
        <section class="panel">
            <header class="panel-heading">Top 10 khách hàng mua hàng nhiều nhất (đã trừ trả hàng)</header>
            <div class="panel-body" >
                <div id="graph" class="jsGraph {!! !empty($_GET['display']) && $_GET['display'] == 'table' ? 'disabled' : '' !!}"></div>
                <div class="jsTable adv-table {!! empty($_GET['display']) || $_GET['display'] == 'graph' ? 'disabled' : '' !!}">
                    @if(!empty($bill_sales))
                    <table class="display table table-bordered" id="hidden-table-info">
                        <thead>
                            <tr>
                                <th class="w-100"></th>
                                <th>Khách hàng</th>
                                <th>Doanh thu</th>
                                <th>Giá vốn</th>
                                <th>Lợi nhuận</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill_sales as $key => $bill_sale)  
                            <tr class="gradeX old" attr-key-old="<?=$key?>">
                                <td class="center">
                                    <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                                </td>
                                <?php
                                    $price_sale_total = $bill_sale['report_time']->sum;
                                    $price_base_total =  $bill_sale['report_time']->base_total;
                                    $profit_total = $price_sale_total -$price_base_total;
                                ?>
                                <td>{!! $bill_sale['report_time']->customer->name; !!}</td>
                                <td>{!! number_format($price_sale_total) !!}</td>
                                <td>{!! number_format($price_base_total) !!}</td>
                                <td>{!! number_format($profit_total) !!}</td>
                            </tr>
                            <tr class="disabled" attr-key="<?=$key?>">
                                <td class="details" colspan="6">
                                    <div class="tab-content js-detail">
                                        <div class="col-lg-12">                                        
                                            <table class="display table table-bordered" id="hidden-table-info">
                                                <thead>
                                                    <tr>
                                                        <th class="w-100">Mã</th>
                                                        <th>Hóa đơn</th>
                                                        <th>Nhân viên</th>                                                        
                                                        <th>Ghi chú</th>
                                                        <th>Doanh thu</th>
                                                        <th>Giá vốn</th>
                                                        <th>Lợi nhuận</th>
                                                        <th class="w-150">Ngày tạo</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($bill_sale['bills']))
                                                        @foreach($bill_sale['bills'] as $bill)
                                                        <tr>
                                                            <td>{!! $bill->code !!}</td>
                                                            <td>{!! $bill->name !!}</td>
                                                            <td>{!! $bill->staff->name or '' !!}</td>                                                            
                                                            <td>{!! nl2br($bill->node) !!}</td>
                                                            <td>{!! number_format($bill->total) !!}</td>
                                                            <td>{!! number_format($bill->base_price_total) !!}</td>
                                                            <td>{!! number_format($bill->total - $bill->base_price_total) !!}</td>
                                                            <td>{!! $bill->sale_date !!}</td>
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
                    @else
                    Không tìm thấy dữ liệu.
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type="text/javascript">
    var chart = Morris.Bar({
        element: 'graph',
        data : [],
        xkey: 'x',
        ykeys: ['y'],
        labels: ['$'],
        barColors: function (row, series, type) {
            if (type === 'bar') {
                var red = Math.ceil(255 * row.y / this.ymax);
                return '#41cac0';
            }
            else {
                return '#000';
            }
        }
    });

    var data = [];
    <?php
    if(!empty($bill_sales)){
        foreach ($bill_sales as $key => $bill_sale) {
            $user = $bill_sale['report_time']->customer->name;
            $money = $bill_sale['report_time']->sum;
    ?>
        var val ={"x": "{!! $user !!}", "y": "{!! $money !!}"};
        data.push(val);
    <?php } ?>
        chart.setData(data)
    <?php }else { ?>
        $('#graph').html('Không tìm thấy dữ liệu.');
    <?php }?>    
</script>
@stop