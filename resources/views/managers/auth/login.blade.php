@extends('layouts.admin-login')
@section('content')
    {!! Form::open(array('url'=>'/management/login','id'=>'frmLogin', 'action'=>'post','class'=>'form-signin' )) !!}
        <h2 class="form-signin-heading">Đăng Nhập</h2>
        <div class="login-wrap">
            {!! Form::text('account', null, array('placeholder'=>'Tài khoản','class'=>'form-control')) !!}
            {!! Form::password('password', array('placeholder'=>'Mật khẩu','class'=>'form-control')) !!}
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Ghi nhớ 
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Quên mật khẩu?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Đăng Nhập</button>
        </div>
          <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success" type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->
    {!! Form::close() !!}
@stop