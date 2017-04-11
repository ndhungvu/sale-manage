<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>HOÁ ĐƠN BÁN HÀNG</title>
         <link media="all" type="text/css" rel="stylesheet" href="/assets/admin/css/base.css">
        {!! Html::script('/assets/admin/js/jquery.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.printPage.js'); !!}        
    </head>
    <body>
        <p>Tên cửa hàng: {!! $bill->company->name or ''; !!}</p>
        <p>Chi nhánh: {!! $bill->branch->name or ''; !!}</p>
        <p>Điện thoại: {!! $bill->branch->phone or ''; !!}</p>
        <hr style="border-top: dotted 1px;" />
        <p>Ngày bán: {!! date('d-m-Y: H:i', strtotime($bill->created_at)); !!}</p>
        <div class="center">
            <p><h2>HOÁ ĐƠN BÁN HÀNG</h2></p>
            <p>({!! $bill->name !!})</p>
        </div>
        @if(!empty($bill->customer))
        <p>Khách hàng: {!! $bill->customer->name  !!}</p>
        <p>Địa chỉ: {!! $bill->customer->address !!}</p>
        <p>{!! !empty($bill->customer->phone) ? 'Điện thoại: '.$bill->customer->phone : ''; !!}</p>
        <p>{!! !empty($bill->customer->mobile) ? 'Di động: '.$bill->customer->mobile : ''; !!}</p>
        @else
          <p>Khách hàng: Khách lẻ</p>
        @endif
        <p>Người bán: {!! $bill->staff->name; !!}</p>
        <hr style="border-top: dotted 1px;" />
        @if(!empty($bill->bill_sale_commodities))
        <?php $bill_commodities = $bill->bill_sale_commodities;?>
        <table class="table table-bordered" border="0" cellspacing="0" cellpadding="0">
            <thead>
                <tr>                   
                    <th class="left">Sản phẩm</th>
                    <th class="w-150 center">Số lượng</th>
                    <th class="w-150 center">Giá</th>
                    <th class="w-150 center">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bill_commodities as $bill_commodity)
                <tr>                   
                    <td>{!! $bill_commodity->commodity->name !!}</td>
                    <td class="center">{!! $bill_commodity->number !!}</td>
                    <td class="center">{!! number_format($bill_commodity->sale_money) !!}</td>
                    <td class="center">{!! number_format($bill_commodity->number*$bill_commodity->sale_money) !!}</td>
                </tr>            
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="center"><p><strong>Tổng tiền hàng:</strong></p></td>
                    <td class="center"><p>{!! number_format($bill->total) !!}</p></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="center"><p><strong>Giảm giá:</strong></p></td>
                    <td class="center"><p>{!! number_format($bill->discount) !!}</p></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="center"><p><strong>Khách cần trả:</strong></p></td>
                    <td class="center"><p>{!! number_format($bill->total - $bill->discount) !!}</p></td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td class="center"><p><strong>Khách thanh toán:</strong></p></td>
                    <td class="center"><p>{!! number_format($bill->pay) !!}</p></td>
                </tr>
                @if($bill->total - $bill->discount - $bill->pay > 0)
                <tr>
                    <td colspan="2"></td>
                    <td class="center"><p><strong>Khách chưa thanh toán:</strong></p></td>
                    <td class="center"><p>{!! number_format($bill->total - $bill->discount - $bill->pay ) !!}</p></td>
                </tr>
                @endif
            </tfoot>
        </table>
        @else
        <p>Không có dữ liệu.</p>
        @endif
    </body>
</html>

