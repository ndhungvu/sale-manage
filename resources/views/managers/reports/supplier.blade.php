@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
    <div class="col-lg-3">
        <section class="panel">
            <header class="panel-heading">
                Báo cáo nhân viên
            </header>
            <div class="panel-body" >
                <header class="panel-heading jsPannel">
                    Kiểu hiển thị
                </header>
                <div class="form-group">
                    <div class="radios">
                        <label class="label_radio" for="graph">
                            <input name="display" id="radio" class="jsRadioDisplay" value="graph" type="radio" checked="checked"> Biểu đồ
                        </label>
                        <label class="label_radio" for="table">
                            <input name="display" id="radio" class="jsRadioDisplay" value="table" type="radio"> Báo cáo
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
                    <select name="commodity_group" class="form-control m-bot15">
                        <option value="">---Tất cả---</option>
                        <option value="1">Chi nhánh 1</option>
                        <option value="2">Chi nhánh 2</option>
                    </select>
                </div>
            </div>
            <div class="panel-body" >
                <header class="panel-heading jsPannel">
                    Thời gian
                </header>
                <div class="form-group">
                    <br>
                    <div class="input-group input-large" data-date="13/07/2013" data-date-format="mm/dd/yyyy">
                        <span class="input-group-addon">Từ</span>
                        <input type="text" class="form-control dpd1" name="from">
                        <span class="input-group-addon">Đến</span>
                        <input type="text" class="form-control dpd2" name="to">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-lg-9">
        <section class="panel">
            <header class="panel-heading">
                Top 10 nhân viên bán hàng nhiều nhất (đã trừ trả hàng)
            </header>
            <div class="panel-body" >
                <div id="graph" class="jsGraph" style="height: 400px;"></div>
                <div class="jsTable adv-table disabled">
                    <div class="text-r-b-20">
                        <a href="#" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</a>
                    </div>
                    <table class="display table table-bordered" id="hidden-table-info">
                        <thead>
                        <tr>
                            <th>Mã NV</th>
                            <th>Họ tên</th> 
                            <th>Doanh thu</th>                           
                        </tr>
                        </thead>
                        <tbody>                           
                            <tr class="gradeX old">
                                <td>NV01</td>
                                <td>Trần Ngọc Gia Lâm</td>
                                <td>50.000.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV04</td>
                                <td>Lê Văn Tỵ</td>
                                <td>15.000.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV05</td>
                                <td>Hoàng Phi</td>
                                <td>8.500.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV06</td>
                                <td>Nguyễn Vũ</td>
                                <td>7.000.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV02</td>
                                <td>Hồ Ngọc Hà</td>
                                <td>6.700.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV03</td>
                                <td>Hoàng Lâm</td>
                                <td>6.500.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV08</td>
                                <td>Võ Hải</td>
                                <td>6.7.000.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV07</td>
                                <td>Trần Ngọc Gia Lâm</td>
                                <td>6.000.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV09</td>
                                <td>Nguyễn Thị Tuyết</td>
                                <td>2.050.000</td>
                            </tr>
                            <tr class="gradeX old">
                                <td>NV10</td>
                                <td>Nguyễn Tấn Nam</td>
                                <td>1.500.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type="text/javascript">
    Morris.Bar({
      element: 'graph',
      data: [
        {x: 'Trần Ngọc Gia Lâm', y: 50},
        {x: 'Nguyễn Thị Tuyết', y: 15},
        {x: 'Lê Văn Tỵ', y: 8.5},
        {x: 'Hoàng Phi', y: 8.0},
        {x: 'Hoàng Lâm', y: 7.1},
        {x: 'Nguyễn Vũ', y: 6.7},
        {x: 'Hồ Ngọc Hà', y: 6},
        {x: 'Võ Hải', y: 2.050},
        {x: 'Nguyễn Tấn Nam', y: 1.5}
      ],
      xkey: 'x',
      ykeys: ['y'],
      labels: ['$'],
      barColors: function (row, series, type) {
        if (type === 'bar') {
          var red = Math.ceil(255 * row.y / this.ymax);
          return 'rgb(' + red + ',0,0)';
        }
        else {
          return '#000';
        }
      }
    });
    $('.jsRadioDisplay').on('click',function(){
        var _type = $(this).val();
        if(_type == 'graph') {
            $('.jsGraph').show();
            $('.jsTable').hide();
        }else {
            $('.jsTable').show();
            $('.jsGraph').hide();
        }
    })
</script>
@stop