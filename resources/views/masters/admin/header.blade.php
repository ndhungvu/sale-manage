 <header class="header white-bg">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="fa fa-bars"></span>
        </button>
        <!--logo start-->
        <a href="javascript:;" class="logo" >Sales<span>Manager</span></a>
        <!--logo end-->
        <div class="horizontal-menu navbar-collapse collapse ">
            <ul class="nav navbar-nav">
                <li class="@if(Route::is('admin.companies')) active @endif"><a href="{{ route('admin.companies') }}"><i class="fa fa-group"></i>Công ty</a></li>
                <li class="@if(Route::is('admin.users')) active @endif"><a href="{{ route('admin.users') }}"><i class="fa fa-group"></i>Người dùng</a></li>
            </ul>
        </div>
        <div class="top-nav ">
            <ul class="nav pull-right top-menu">
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img width="30" height="30" alt="Avatar" src="{!! !empty(Auth::user()->avatar) ? '/uploads/avatars/'.Auth::user()->avatar : '/assets/admin/img/avatar1_small.jpg'!!}">
                        <span class="username">{!! Auth::user()->name !!}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="{!! route('admin.profile') !!}"><i class=" fa fa-suitcase"></i>Thông tin tài khoản</a></li>
                        <li><a href="{!! route('admin.profile.change-password') !!}"><i class="fa fa-cog"></i>Thay đổi mật khẩu</a></li>
                        <li><a href="{!! route('admin.logout') !!}"><i class="fa fa-sign-out"></i>Thoát</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
        </div>
    </div>
</header>