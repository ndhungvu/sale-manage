@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
  <section class="panel">
      <header class="panel-heading">Khách hàng</header>
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('masters.message')
            </div>
        </div>
      <div class="panel-body">
        <!--Search-->
        {!! Form::open(array('id'=>'search','method'=>'GET', 'class'=>'form-horizontal filter-form-custom')) !!}
           <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Mã | Tên KH | Điện thoại</label>
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
        <hr>        
        <div class="adv-table">
            <div class="text-r-b-20">
                <button class="btn btn-primary" data-toggle="modal" href="#create"><i class="fa fa-plus-square"></i> Thêm mới</button>
                <button class="btn btn-primary"><i class="fa fa fa-sign-in"></i> Import</button>
                <a href="{!! route('management.customers.export') !!}" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</a>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Mã KH</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($customers) && count($customers) > 0)
                        @foreach($customers as $key => $customer)
                        <tr class="gradeX old" attr-key-old="<?=$key?>">
                            <td class="center">
                                <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                            </td>
                            <td>{!! $customer->code !!}</td>
                            <td>{!! $customer->name !!}</td>
                            <td>{!! $customer->mobile !!}</td>
                            <td>{!! $customer->email !!}</td>
                            <td>{!! $customer->address !!}</td>
                        </tr>
                        <tr class="disabled" attr-key="<?=$key?>">
                            <td class="details" colspan="6">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home_{!! $key !!}" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>
                                    <li role="presentation"><a href="#history_{!! $key !!}" aria-controls="profile" role="tab" data-toggle="tab">Nợ cần thu từ khách</a></li>
                                </ul>                               
                                <div class="tab-content js-detail">
                                    <div role="tabpanel" class="tab-pane active row" id="home_{!! $key !!}">
                                        <div class="col-lg-12">                                        
                                            <div class="col-lg-6">
                                                <p><label class="col-lg-4">Mã KH</label> {!! $customer->code !!}</p>                                                
                                                <p><label class="col-lg-4">Điện thoại</label> {!! $customer->phone !!} - {!! $customer->mobile !!}</p>
                                                <p><label class="col-lg-4">Giới tính</label> {!! $customer->gender == 1 ? 'Nam' : 'Nữ' !!}</p>
                                                <p><label class="col-lg-4">CMND</label> {!! $customer->cmnd !!}</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><label class="col-lg-4">Tên KH</label>{!! $customer->name !!}</p>
                                                <p><label class="col-lg-4">Email</label>{!! $customer->email !!}</p>
                                                <p><label class="col-lg-4">Ngày sinh</label> {!! date('Y-m-d', strtotime($customer->birthday)); !!}</p>
                                                <p><label class="col-lg-4">Địa chỉ</label>{!! $customer->address !!}</p>
                                            </div>                                                                               
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" data-toggle="modal" href="#edit_{!! $key !!}"><i class="fa fa-edit"></i>Cập nhật</button>
                                            <a href="javascript:void();" attr-key="<?=$key?>" attr-href="/management/customers/delete/{!! $customer->id !!}" class="btn btn-danger jsDelete">Xóa</a>                                        
                                        </div>
                                        <!-- Edit -->
                                        <div class="modal fade" id="edit_{!! $key !!}" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                              <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Sửa khách hàng</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(array('url' => '/management/customers/edit/'.$customer->id,'id'=>'frmEdit_'.$key,'class'=>'form-horizontal filter-form-custom')) !!}
                                                            <form class="form-horizontal" role="form">
                                                            <div class="form-group">                       
                                                                <label class="col-lg-2 col-sm-2 control-label">Tên khách hàng<span class="required">*</span></label>
                                                                <div class="col-lg-10">
                                                                    <input type="text" class="form-control" name="name" value="{!! $customer->name !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="address" value="{!! $customer->address !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Email</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="email" value="{!! $customer->email !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="phone" value="{!! $customer->phone !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mobile" value="{!! $customer->mobile !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Giới tính</label>
                                                                <div class="col-lg-4">
                                                                   <div class="radios">
                                                                      <label class="label_radio" for="radio-01">
                                                                          <input name="gender" id="gender_1" value="1" type="radio" {!! $customer->gender == 1 ? 'checked' : '' !!}> Nam
                                                                      </label>
                                                                      <label class="label_radio" for="radio-02">
                                                                          <input name="gender" id="gender_" value="0" type="radio" {!! $customer->gender == 0 ? 'checked' : '' !!}> Nữ
                                                                      </label>                             
                                                                  </div>
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Ngày sinh</label>
                                                                <div class="col-lg-3">
                                                                    <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                                                                        <input type="text" size="16" class="form-control" name="birthday" value="{!! date('Y-m-d',strtotime($customer->birthday)) !!}">
                                                                        <span class="input-group-btn add-on">
                                                                            <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                  </div>
                                                                </div>
                                                            </div>                    
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">CMND</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="cmnd" value="{!! $customer->cmnd !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Mã số thuế</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mst" value="{!! $customer->mst !!}">
                                                                </div>
                                                            </div>                    
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                                                                </div>
                                                            </div>
                                                        {!! Form::close() !!}    
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                        <!-- End Edit -->                                   
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="history_{!! $key !!}">
                                        <table class="display table table-bordered" id="hidden-table-info">
                                            <thead>
                                                <tr>
                                                    <th class="w-100">Mã phiếu</th>
                                                    <th>Thời gian</th>
                                                    <th>Giá trị</th>
                                                    <th>Dư nợ khách hàng</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($customer->billSales)
                                                    <?php $billSales = $customer->billSales?>
                                                    @foreach($billSales as $billSale)
                                                    <tr>
                                                        <td>{!! $billSale->code !!}</td>
                                                        <td>{!! $billSale->name !!}</td>
                                                        <td>{!! $billSale->total !!}</td>
                                                        <td>{!! $billSale->total - $billSale->pay !!}</td>
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
                    @else
                    <tr><td colspan="6">Không có dữ liệu</td></tr>
                    @endif
                </tbody>
            </table>            
            <!--Pagination-->
            <?php echo $customers->render(); ?>
        </div>
      </div>
  </section>
</div>
<!-- Create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Thêm mới</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => '/management/customers/create','id'=>'frmCreate','class'=>'form-horizontal filter-form-custom')) !!}
                    <div class="form-group">                       
                        <label class="col-lg-2 col-sm-2 control-label">Tên khách hàng<span class="required">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="address">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Giới tính</label>
                        <div class="col-lg-4">
                           <div class="radios">
                              <label class="label_radio" for="radio-01">
                                  <input name="gender" id="gender_1" value="1" type="radio" checked> Nam
                              </label>
                              <label class="label_radio" for="radio-02">
                                  <input name="gender" id="gender_" value="0" type="radio"> Nữ
                              </label>                             
                          </div>
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Ngày sinh</label>
                        <div class="col-lg-3">
                            <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                                <input type="text" size="16" class="form-control" name="birthday">
                                <span class="input-group-btn add-on">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                          </div>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">CMND</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="cmnd">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Mã số thuế</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="mst">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                        </div>
                    </div>
                {!! Form::close() !!}    
            </div>
      </div>
  </div>
</div>
<!-- End create -->
<script type="text/javascript">
    $(document).ready(function(){        
        var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        /*Validation form*/  
        $("#frmCreate").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/management/customers/check-exist-email",
                        type: "POST",
                        data: {_token: _CSRF_TOKEN}
                     }
                }
            },
            messages: {
                name: "Họ tên không được để trống.",
                email: {
                    required: "Email không được để trống.",
                    email: "Email không đúng định dạng.",
                    remote: "Email đã được sữ dụng."
                }               
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
        @if(!empty($customers))
            @foreach($customers as $key => $customer)
            $("#frmEdit_{!! $key !!}").validate({
                rules: {
                    name: "required"
                },
                messages: {
                    name: "Họ tên không được để trống."                
                }
            });
            @endforeach
        @endif
    });
</script>
@stop