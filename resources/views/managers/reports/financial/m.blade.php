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
                    <div class="radios">
                        <label class="label_radio" for="graph">
                            <input name="sort_time" id="radio" value="m" type="radio" {!! empty($_GET['sort_time']) || $_GET['sort_time'] == 'm' ? 'checked' : '' !!}> Theo Tháng
                        </label>
                        <label class="label_radio" for="table">
                            <input name="sort_time" id="radio" value="q" type="radio" {!! !empty($_GET['sort_time']) && $_GET['sort_time'] == 'q' ? 'checked' : '' !!}> Theo Quý
                        </label>
                        <label class="label_radio" for="table">
                            <input name="sort_time" id="radio" value="y" type="radio" {!! !empty($_GET['sort_time']) && $_GET['sort_time'] == 'y' ? 'checked' : '' !!}> Theo Năm
                        </label>                        
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
            <header class="panel-heading">Báo cáo tài chính</header>
            <div class="panel-body" >
                <div id="graph" class="jsGraph {!! !empty($_GET['display']) && $_GET['display'] == 'table' ? 'disabled' : '' !!}"></div>
                <div class="jsTable adv-table {!! empty($_GET['display']) || $_GET['display'] == 'graph' ? 'disabled' : '' !!}">
                    <!--<div class="text-r-b-20">
                        <a href="#" class="btn btn-primary" disabled><i class="fa fa fa-file-text-o"></i> Xuất file</a>
                    </div>-->
                    @if(!empty($bill_sales))
                    <table class="display table table-bordered" id="hidden-table-info">
                        <thead>
                            <tr>
                                <th>Thời gian ({!! date('Y') !!}) </th>
                                <th>Doanh thu</th>
                                <th>Giá vốn</th>
                                <th>Lợi nhuận</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill_sales as $key => $bill_sale)  
                            <tr>
                                <?php
                                    $price_sale_total = $bill_sale['report_time']->sum;
                                    $price_base_total =  $bill_sale['report_time']->base_total;
                                    $profit_total = $price_sale_total -$price_base_total;
                                ?>
                                <td>Tháng {!! $bill_sale['report_time']->month; !!}</td>
                                <td>{!! number_format($price_sale_total) !!}</td>
                                <td>{!! number_format($price_base_total) !!}</td>
                                <td>{!! number_format($profit_total) !!}</td>
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
            $date = $bill_sale['report_time']->month .'/'.date('Y');
            $money = $bill_sale['report_time']->sum;
    ?>
        var val ={"x": "{!! $date !!}", "y": "{!! $money !!}"};
        data.push(val);
    <?php } ?>
        chart.setData(data)
    <?php }else { ?>
        $('#graph').html('Không tìm thấy dữ liệu.');
    <?php }?>    
</script>
@stop