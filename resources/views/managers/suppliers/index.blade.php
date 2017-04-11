@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
  <section class="panel">
      <header class="panel-heading">Nhà cung cấp</header>
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('masters.message')
            </div>
        </div>
      <div class="panel-body">
        <!--Search-->
        {!! Form::open(array('id'=>'search','method'=>'GET', 'class'=>'form-horizontal filter-form-custom')) !!}
           <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Mã NCC | Tên | Điện thoại</label>
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
                <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</button>
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Mã NCC</th>
                    <th>Tên NCC</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($suppliers) && count($suppliers) > 0)
                        @foreach($suppliers as $key => $supplier)
                        <tr class="gradeX old" attr-key-old="<?=$key?>">
                            <td class="center">
                                <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                            </td>
                            <td>{!! $supplier->code !!}</td>
                            <td>{!! $supplier->name !!}</td>
                            <td>{!! $supplier->mobile !!}</td>
                            <td>{!! $supplier->email !!}</td>
                            <td>{!! $supplier->address !!}</td>
                        </tr>
                        <tr class="disabled" attr-key="<?=$key?>">
                            <td class="details" colspan="6">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home_{!! $key !!}" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>
                                    <li role="presentation"><a href="#history_{!! $key !!}" aria-controls="profile" role="tab" data-toggle="tab">Lịch sử cung cấp hàng</a></li>
                                </ul>                               
                                <div class="tab-content js-detail">
                                    <div role="tabpanel" class="tab-pane active row" id="home_{!! $key !!}">
                                        <div class="col-lg-12">                                        
                                            <div class="col-lg-6">
                                                <p><label class="col-lg-4">Mã NCC</label> {!! $supplier->code !!}</p>
                                                <p><label class="col-lg-4">Tên NCC</label>{!! $supplier->name !!}</p>
                                                <p><label class="col-lg-4">Email</label>{!! $supplier->email !!}</p>                                                
                                                <p><label class="col-lg-4">Địa chỉ</label>{!! $supplier->address !!}</p>                                            
                                            </div>
                                            <div class="col-lg-6">
                                                <p><label class="col-lg-4">Điện thoại</label> {!! $supplier->phone !!}</p>
                                                <p><label class="col-lg-4">Di động</label> {!! $supplier->mobile !!}</p>
                                                <p><label class="col-lg-4">Mã số thuế</label> {!! $supplier->mst !!}</p>
                                            </div>                                                                               
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" data-toggle="modal" href="#edit_{!! $key !!}"><i class="fa fa-edit"></i>Cập nhật</button>
                                            <a href="javascript:void();" attr-key="<?=$key?>" attr-href="/management/suppliers/delete/{!! $supplier->id !!}" class="btn btn-danger jsDelete">Xóa</a>                                        
                                        </div>
                                        <!-- Edit -->
                                        <div class="modal fade" id="edit_{!! $key !!}" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                              <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Cập nhật nhà cung cấp</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(array('url' => '/management/suppliers/edit/'.$supplier->id,'id'=>'frmEdit_'.$key,'class'=>'form-horizontal filter-form-custom')) !!}
                                                            <form class="form-horizontal" role="form">
                                                            <div class="form-group">                       
                                                                <label class="col-lg-2 col-sm-2 control-label">Tên nhà cung cấp<span class="required">*</span></label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="name" value="{!! $supplier->name !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Email</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="email" value="{!! $supplier->email !!}">
                                                                </div>
                                                            </div>                                                            
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="phone" value="{!! $supplier->phone !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mobile" value="{!! $supplier->mobile !!}">
                                                                </div>
                                                            </div> 
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="address" value="{!! $supplier->address !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Mã số thuế</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mst" value="{!! $supplier->mst !!}">
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
                                        Đang câp nhật ...
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
            <?php echo $suppliers->render(); ?>
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
                {!! Form::open(array('url' => '/management/suppliers/create','id'=>'frmCreate','class'=>'form-horizontal filter-form-custom')) !!}
                    <div class="form-group">                       
                        <label class="col-lg-2 control-label">Tên nhà cung cấp<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name">
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
                        <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="address">
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
                        url: "/management/suppliers/check-exist-email",
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
        @if(!empty($suppliers))
            @foreach($suppliers as $key => $supplier)
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