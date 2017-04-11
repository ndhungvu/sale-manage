@extends('layouts.admin')
@section('content')
<div class="col-lg-12">
  <section class="panel">
      <header class="panel-heading">Người dùng</header>
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('masters.message')
            </div>
        </div>
      <div class="panel-body">
        <!--Search-->
        {!! Form::open(array('id'=>'search','method'=>'GET', 'class'=>'form-horizontal filter-form-custom')) !!}
           <div class="form-group">
                <label for="inputEmail1" class="col-lg-3 control-label">Họ tên | Tên đăng nhập | Điện thoại</label>
                <div class="col-lg-9">
                    <input type="text" class="form-control" name="search" value="{!! !empty($_GET['search']) ? $_GET['search'] : '' !!}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Ngày tạo</label>
                <div class="col-lg-3">
                    <label class="col-lg-4 control-label">Từ ngày</label>
                    <div class="col-lg-8">
                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="<?=date('d-m-Y');?>" class="input-append date dpYears">
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
                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="<?=date('d-m-Y');?>" class="input-append date dpYears">
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
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Tên đăng nhập</th>
                    <th>Họ tên</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Công ty</th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($users) && count($users) > 0)
                        @foreach($users as $key => $user)
                        <tr class="gradeX old" attr-key-old="<?=$key?>">
                            <td class="center">
                                <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                            </td>
                            <td>{!! $user->nickname !!}</td>
                            <td>{!! $user->name !!}</td>
                            <td>{!! $user->mobile !!}</td>
                            <td>{!! $user->email !!}</td>
                            <td>{!! $user->address !!}</td>
                            <td>{!! !empty($user->company) ? $user->company->name : '' !!}</td>
                        </tr>
                        <tr class="disabled" attr-key="<?=$key?>">
                            <td class="details" colspan="7">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home_{!! $key !!}" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>                                    
                                </ul>                               
                                <div class="tab-content js-detail">
                                    <div role="tabpanel" class="tab-pane active row" id="home_{!! $key !!}">
                                        <div class="col-lg-12">                                                                                 
                                            <div class="col-lg-4">                                                
                                                <p><label class="col-lg-5 clear">Tên đăng nhập</label> {!! $user->nickname !!}</p>
                                                <p><label class="col-lg-5 clear">Tên NV</label>{!! $user->name !!}</p>
                                                <p><label class="col-lg-5 clear">Giới tính</label> {!! $user->gender == 1 ? 'Nam' : 'Nữ' !!}</p>                                                
                                                <p><label class="col-lg-5 clear">Ngày sinh</label> {!! date('Y-m-d', strtotime($user->birthday)); !!}</p>
                                                <p><label class="col-lg-5 clear">Địa chỉ</label>{!! $user->address !!}</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p><label class="col-lg-5 clear">CMND</label> {!! $user->cmnd !!}</p>                                                
                                                <p><label class="col-lg-5 clear">Điện thoại</label> {!! $user->phone !!}</p>
                                                <p><label class="col-lg-5 clear">Di động</label> {!! $user->mobile !!}</p>                                                
                                                <p><label class="col-lg-5 clear">MST</label> {!! $user->mst !!}</p>
                                                <p><label class="col-lg-5 clear">Công ty</label>{!! !empty($user->company) ? $user->company->name : '' !!}</p>
                                            </div>
                                             <div class="col-lg-2">
                                                <img class="img-thumbnail" src="{!! '/uploads/avatars/'.$user->avatar !!}" alt="" width="140" height="140" />
                                            </div>                                                                                 
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" data-toggle="modal" href="#edit_{!! $key !!}"><i class="fa fa-edit"></i>Cập nhật</button>
                                            <a href="javascript:void();" attr-key="<?=$key?>" attr-href="{!! route('admin.users.delete', $user->id) !!}" class="btn btn-danger jsDelete">Xóa</a>                                        
                                        </div>
                                        <!-- Edit -->
                                        <div class="modal fade" id="edit_{!! $key !!}" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                              <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Cập nhật người dùng</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(array('route' => array('admin.users.edit', $user->id),'id'=>'frmEdit_'.$key,'class'=>'form-horizontal filter-form-custom')) !!}
                                                            <div class="form-group">                       
                                                                <label class="col-lg-2 col-sm-2 control-label">Họ tên<span class="required">*</span></label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="name" value="{!! $user->name !!}">
                                                                </div>
                                                                <label class="col-lg-2 control-label">Mật khẩu<span class="required">*</span></label>
                                                                <div class="col-lg-4">
                                                                    <div class="col-lg-8 hidePassword">                                                                    
                                                                        <span class="control-label">**********</span>                        
                                                                    </div>
                                                                    <div class="col-lg-8 jsDisabled jsPassword">
                                                                        <input type="text" class="form-control" name="password" id="password" value="">
                                                                    </div>
                                                                    <a class="btn btn-primary jsChangePass_{!! $user->id !!}" href="javascript:;" attr-type="change">Thay đổi</a>
                                                                </div>

                                                            </div>
                                                            <div class="form-group">
                                                                
                                                               
                                                                
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="address" value="{!! $user->address !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">CMND</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="cmnd" value="{!! $user->cmnd !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="phone" value="{!! $user->phone !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mobile" value="{!! $user->mobile !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Ngày sinh</label>
                                                                <div class="col-lg-4">
                                                                    <div class="col-lg-12" style="margin-left: -5%;">                                                                  
                                                                        <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="{!! $user->birthday !!}" class="input-append date dpYears">
                                                                            <input type="text" size="16" class="form-control" name="birthday" value="{!! date('d-m-Y',strtotime($user->birthday)) !!}">
                                                                            <span class="input-group-btn add-on">
                                                                                <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Mã số thuế</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mst" value="{!! $user->mst !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Giới tính</label>
                                                                <div class="col-lg-4">
                                                                    <div class="radios">
                                                                        <label class="label_radio" for="radio-01">
                                                                          <input name="gender" id="gender_1" value="1" type="radio"  value="{!! $user->gender == 1 ? 'checked' : '' !!}"> Nam
                                                                        </label>
                                                                        <label class="label_radio" for="radio-02">
                                                                          <input name="gender" id="gender_" value="0" type="radio" value="{!! $user->gender == 0 ? 'checked' : '' !!}"> Nữ
                                                                        </label>                             
                                                                    </div>
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Công ty<span class="required">*</span></label>
                                                                <div class="col-lg-4">
                                                                    <select class="form-control jsSelectCompany" name="company_id">
                                                                        <option value="">---Chọn---</option>
                                                                        <?php if(!empty($companies) && count($companies) > 0): 
                                                                        foreach ($companies as $key => $company) {
                                                                        ?>
                                                                        <option value="{!! $company->id!!}" {!! $company->id == $user->company_id ? 'selected = "selected"' : '' !!}>{!! $company->name!!}</option>
                                                                        <?php }
                                                                        endif;?>
                                                                    </select>
                                                                </div>                         
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Hình đại diện</label>
                                                                <div class="col-lg-4 upload-file">
                                                                    {!! Html::image('/uploads/avatars/'.$user->avatar, 'Avatar', array('class'=>'img-rounded img-active','width'=>150, 'height'=> 150)) !!} 
                                                                    <input type = "hidden" name = "image_old" value = "/uploads/avatars/{!! $user->avatar!!}" />
                                                                    <input type = "hidden" name = "image_tmp" value=""/>
                                                                    <div class="rows">
                                                                        <a class="btn btn-primary btn-xs jsUploadImage" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-fw fa-pencil"></i></a>
                                                                        <a class="btn btn-danger btn-xs jsDeleteImage" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa fa-trash-o"></i></a>                                                
                                                                        <img src="{!! asset('/assets/admin/img/loading.gif') !!}" alt="Loading..." class= "jsLoading" /> 
                                                                        <input id="image" type="file" class="jsImage" data-overwrite-initial="false" name="image" attr-url="/admin/users/change-avatar">
                                                                    </div>  
                                                                </div>                        
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                                                                </div>
                                                            </div>
                                                        {!! Form::close() !!}
                                                        <script type="text/javascript">
                                                             $('.jsChangePass_{!! $user->id !!}').bind('click', function () {
                                                                    var _this = $(this);
                                                                    var _type = _this.attr('attr-type');
                                                                    if (_type == 'change') {
                                                                        _this.text('Hủy').attr('attr-type', 'unchange');
                                                                        $('.jsPassword').removeClass('jsDisabled');
                                                                        $('.hidePassword').addClass('jsDisabled');
                                                                    } else {
                                                                        _this.closest('.form-group').find('#password').val('');
                                                                        _this.text('Thay đổi').attr('attr-type', 'change');
                                                                        $('.jsPassword').addClass('jsDisabled');
                                                                        $('.hidePassword').removeClass('jsDisabled');
                                                                    }
                                                                });
                                                        </script>
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                        <!-- End Edit -->                                   
                                    </div>                                                                    
                                </div>
                            </td>                                             
                        </tr>
                        @endforeach
                    @else
                    <tr><td colspan="7">Kông có dữ liệu</td></tr>
                    @endif
                </tbody>
            </table>            
            <!--Pagination-->
            <?php echo $users->render(); ?>
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
                {!! Form::open(array('route' => 'admin.users.create','id'=>'frmCreate','class'=>'form-horizontal filter-form-custom')) !!}
                    <div class="form-group">                       
                        <label class="col-lg-2 col-sm-2 control-label">Họ tên<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Tên đăng nhập<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="nickname">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Email<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <input type="email" class="form-control" name="email">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Mật khẩu<span class="required">*</span></label>
                        <div class="col-lg-2">
                            <input type="text" class="form-control" name="password" id="password" value="123456">
                        </div>
                        <button type="button" class="col-lg-1 btn btn-primary jsAutoPassword">Tự động</button>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="address">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">CMND</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="cmnd">
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
                        <label class="col-lg-2 col-sm-2 control-label">Ngày sinh</label>
                        <div class="col-lg-4">
                            <div class="col-lg-12" style="margin-left: -5%;">
                                <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="<?=date('d-m-Y');?>" class="input-append date dpYears">
                                    <input type="text" size="16" class="form-control" name="birthday">
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Mã số thuế</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="mst">
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
                        <label class="col-lg-2 col-sm-2 control-label">Công ty<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <select class="form-control jsSelectCompany" name="company_id">
                                <option value="">---Chọn---</option>
                                <?php if(!empty($companies) && count($companies) > 0): 
                                foreach ($companies as $key => $company) {
                                ?>
                                <option value="{!! $company->id!!}">{!! $company->name!!}</option>
                                <?php }
                                endif;?>
                            </select>
                        </div>                         
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Hình đại diện</label>
                        <div class="col-lg-4 upload-file">
                            {!! Html::image('/uploads/avatars/no-avatar.png', 'Avatar', array('class'=>'img-rounded img-active','width'=>150, 'height'=> 150)) !!} 
                            <input type = "hidden" name = "image_old" value = "/uploads/avatars/no-avatar.png"/>
                            <input type = "hidden" name = "image_tmp" value = ""/>
                            <div class="rows">
                                <a class="btn btn-primary btn-xs jsUploadImage" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-fw fa-pencil"></i></a>
                                <a class="btn btn-danger btn-xs jsDeleteImage" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Xóa"><i class="fa fa-trash-o"></i></a>                                                
                                <img src="{!! asset('/assets/admin/img/loading.gif') !!}" alt="Loading..." class= "jsLoading" /> 
                                <input id="image" type="file" class="jsImage" data-overwrite-initial="false" name="image" attr-url="/admin/users/change-avatar">
                            </div>  
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
                nickname: {
                    required: true,
                    remote: {
                        url: "/admin/users/check-exist-nickname",
                        type: "POST",
                        data: {_token: _CSRF_TOKEN}
                    }              
                },
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "/admin/users/check-exist-email",
                        type: "POST",
                        data: {_token: _CSRF_TOKEN}
                    }              
                },
                password: "required",
                company_id: {required: true},
            },
            messages: {
                name: "Họ tên không được để trống.",
                nickname: {
                    required: "Tên đăng nhập không được để trống.",
                    remote: "Tên đăng nhập đã được sữ dụng."                    
                },
                email: {
                    required: "Email không được để trống.",
                    email: "Email không đúng định dạng.",
                    remote: "Email đã được sữ dụng."                    
                },
                password: "Mật khẩu không được để trống.",
                company_id: "Vui lòng chọn công ty.",
            }
        });
        @if(!empty($users))
            @foreach($users as $key => $user)
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

        $('.jsAutoUsername').on('click',function(){
            var _this = $(this);
            var _url = '/admin/users/auto-nickname';
            var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: _url,
                type: "POST",
                data: {_token: _CSRF_TOKEN},
                dataType: 'JSON',
                success: function(res){
                    if(res.status) {
                        $('#username').val(res.data);                        
                    }
                },
                error:function(){
                }
            });
        });

        $('.jsAutoPassword').on('click',function(){
            var _this = $(this);
            var _url = '/admin/users/auto-password';
            var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: _url,
                type: "POST",
                data: {_token: _CSRF_TOKEN},
                dataType: 'JSON',
                success: function(res){
                    if(res.status) {
                        $('#password').val(res.data);                        
                    }
                },
                error:function(){
                }
            });
        });
    });
</script>
@stop