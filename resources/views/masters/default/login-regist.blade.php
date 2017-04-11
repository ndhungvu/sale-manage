<div class="login-regist">
    <div class="form-login">
        <div class="child-lg">
            <h3>ĐĂNG NHẬP</h3>
            <div class="lg-type">
                <a href="{!! URL::route('auth.facebook')!!}" class="fb-but"><i class="fa fa-facebook"></i>Facebook</a>
                <a href="{!! URL::route('auth.twitter')!!}" class="tw-but"><i class="fa fa-twitter"></i>Twitter</a>
            </div>
            <div class="sign-form">
                <span class="jsError jsMessageError"></span>
                <form id="frmLogin" action="" method="POST"> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                   
                    <label for="user-n">Tài khoản</label>
                    <input class="" id="user-n" type="text" placeholder="Email" name="email">
                    <span class="jsError jsEmailError"></span>
                    <label for="pas">Mật khẩu</label>
                    <input id="pas" type="password" placeholder="Mật khẩu" name="password">
                    <span class="jsError jsPasswordError"></span> 
                    <button type="button" class="sb-but jsLogin">Đăng nhập</button>
                </form>
            </div>
            <p class="lost-link">
                <span>Quên mật khẩu?</span>&nbsp;Click để
                <span id="new-regist">Đăng ký mới</span>
            </p>
            <div class="exit-box" id="exit-bt">
                <i class="fa fa-times-circle"></i>
            </div>
        </div>
    </div>
    <div class="form-regist">
        <div class="child-lg">
            <h3>ĐĂNG Ký</h3>
            <div class="lg-type">
                <a href="{!! URL::route('auth.facebook')!!}" class="fb-but"><i class="fa fa-facebook"></i>Facebook</a>
                <a href="{!! URL::route('auth.twitter')!!}" class="tw-but"><i class="fa fa-twitter"></i>Twitter</a>
            </div>
            <div class="sign-form">
                <form method="" action="">
                    <label for="user-n">Họ và tên</label>
                    <input class="bot_15" id="user-n" type="text" placeholder="Họ và tên">
                    <label for="user-n">Email</label>
                    <input class="bot_15" id="user-n" type="text" placeholder="Email">
                    <label for="pas">Mật khẩu</label>
                    <input id="pas" type="password" placeholder="Mật khẩu">   
                    <button type="submit" class="sb-but">Đăng ký</button>
                </form>
            </div>
            <p class="lost-link" id="link-lg">
                Click để <span>Đăng nhập</span>
            </p>
            <div class="exit-box" id="exit-bt-1">
                <i class="fa fa-times-circle"></i>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.jsLogin').on('click', function(){
            $('.jsError').html('').hide();
            var _url = '/auth/login';
            var _CSRF_TOKEN = $('#frmLogin input[name="_token"]').val();
            var _email = $('#frmLogin input[name="email"]').val();
            var _password = $('#frmLogin input[name="password"]').val();
            if(!validateEmail(_email)) {
                $('.jsEmailError').html('Tài khoản không hợp lệ.').show();
                return false;
            }
            if(_password == '') {
                $('.jsPasswordError').html('Mật khẩu không được trống.').show();
                return false;
            }

            $.ajax({
                url: _url,
                type: "POST",
                data: {_token: _CSRF_TOKEN, email: _email, password: _password},
                dataType: 'JSON',
                success: function(res){
                    if(res.status) {
                        window.location.href = "/";                        
                    }else {
                        $('.jsMessageError').html(res.message).show();
                    }
                },
                error:function(){
                }
            });
        });
        
        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    });
</script>