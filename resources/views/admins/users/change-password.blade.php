@extends('layouts.admin')
@section('content')
<div class="row">
    <aside class="profile-nav col-lg-3">
        @include('admins.users.profile-left');
    </aside>
    <aside class="profile-info col-lg-9">
        <section>
            <div class="panel panel-primary">
                <div class="panel-heading">Thay đổi mật khẩu</div>
                <div class="panel-body">
                    {!! Form::open(array('route'=>'admin.profile.change-password','id'=>'frmChangePassword','class'=>'form-horizontal filter-form-custom')) !!}             
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Mật khâu cũ</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="******">
                            </div>
                        </div>
                      <div class="form-group">
                          <label  class="col-lg-2 control-label">Mật khâu mới</label>
                          <div class="col-lg-10">
                              <input type="password" class="form-control" id="new_password" name="new_password" placeholder="******">
                          </div>
                      </div>
                      <div class="form-group">
                          <label  class="col-lg-2 control-label">Lặp lại mật khâu mới</label>
                          <div class="col-lg-10">
                              <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="******">
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                                <a href="{!! route('admin.profile') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> Trở về</a>
                          </div>
                      </div>
                  {!! Form::close() !!}
              </div>
          </div>
      </section>
    </aside>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("#frmChangePassword").validate({
            rules: {
                old_password: {
                    required: true,
                    remote: {
                        url: "/admin/profile/check-password",
                        type: "POST",
                        data: {
                            'old_password':$('input[name=old_password]').value, 
                            '_token': _CSRF_TOKEN
                        }
                    }  
                },
                new_password: "required",
                repeat_password: {
                   required: true,
                   equalTo: "#new_password",
                }
            },
            messages: {
                old_password: {
                    required: "Mật khâu cũ không được để trống.",
                    remote: 'Mật khâu cũ không chính xác' 
                },
                new_password: "Mật khâu mới không được để trống.",
                repeat_password: {
                   required: "Lặp lại mật khâu mới không được để trống.",
                   equalTo: 'Không trùng với mật khẩu mới'
                }
            }
        });
    })
</script>
@stop