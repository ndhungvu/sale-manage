@extends('layouts.manager')
@section('content')
<div class="row">
    <aside class="profile-nav col-lg-3">
        @include('managers.profiles.left');
    </aside>
    <aside class="profile-info col-lg-9">
        <section>          
            <div class="panel panel-primary">
                <div class="panel-heading">Cập nhật tài khoản</div>
                <div class="panel-body">
                    {!! Form::open(array('route'=>'management.profile.edit','id'=>'frmEdit','class'=>'form-horizontal filter-form-custom')) !!}             
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Họ tên<span class="required">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="{!! $profile->name !!}">
                            </div>
                        </div>                       
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Địa chỉ</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="address" name="address" value="{!! $profile->address !!}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Giới tính</label>
                            <div class="radios">
                                <label class="label_radio" for="radio-01">
                                    <input name="gender" id="gender_1" value="1" type="radio" {!! $profile->gender == 1 ? 'checked' : '' !!}> Nam
                                </label>
                                <label class="label_radio" for="radio-02">
                                     <input name="gender" id="gender_" value="0" type="radio" {!! $profile->gender == 0 ? 'checked' : '' !!}> Nữ
                                </label>                             
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Ngày sinh</label>
                            <div class="col-lg-3">
                                <div data-date-viewmode="years" data-date-format="dd-mm-yyyy" data-date="{!! date('d-m-Y', strtotime($profile->birthday)) !!}" class="input-append date dpYears">
                                    <input type="text" size="16" class="form-control" name="birthday" value="{!! date('d-m-Y', strtotime($profile->birthday)) !!}">
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Điện thoại</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="phone" name="phone" value="{!! $profile->phone !!}">
                          </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Di động</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="mobile" name="mobile" value="{!! $profile->mobile !!}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">CMND</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="cmnd" name="cmnd" value="{!! $profile->cmnd !!}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                                <a href="{!! route('management.profile') !!}" class="btn btn-default"><i class="fa fa-mail-reply"></i> Trở về</a>
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
        $("#frmEdit").validate({
            rules: {
                name: "required",                
            },
            messages: {
                name: "Họ tên không được để trống."                
            }
        });
    })
</script>
@stop