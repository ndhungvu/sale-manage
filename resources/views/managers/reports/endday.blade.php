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
                <div class="form-group right">
                    <button class="btn btn-primary jsSubmit"><i class="fa fa-search"></i>Tìm kiếm</button>
                </div>
            </div>            
            {!! Form::close() !!}
        </section>
    </div>
    <div class="col-lg-9">
        <section class="panel">
            <header class="panel-heading">Báo cáo cuối ngày về bán hàng</header>
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
                                <th class="w-100"></th>
                                <th>Thời gian</th>
                                <th>Doanh thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill_sales as $key => $bill_sale)  
                            <tr class="gradeX old" attr-key-old="<?=$key?>">
                                <td class="center">
                                    <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                                </td>
                                <td>{!! $bill_sale['report_time']->sale_date; !!}</td>
                                <td>{!! number_format($bill_sale['report_time']->sum) !!}</td>
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
                                                        <th>Khách hàng</th>
                                                        <th>Ghi chú</th>
                                                        <th>Doanh thu</th>
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
                                                            <td>{!! $bill->customer->name or '' !!}</td>
                                                            <td>{!! nl2br($bill->node) !!}</td>
                                                            <td>{!! number_format($bill->total) !!}</td>
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
            $date = date('d/m/Y', strtotime($bill_sale['report_time']->sale_date));
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