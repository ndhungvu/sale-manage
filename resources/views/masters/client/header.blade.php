<?php $profile = Auth::user();?>
<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-bars tooltips"></div>
    </div>
    <!--logo start-->
    <a href="{{ route('sale') }}" class="logo" >Sales<span>Manager</span></a>
    <div class="top-nav ">
        <ul class="nav pull-right top-menu">
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <img alt="Avatar" src="/uploads/avatars/{!! $profile->avatar or 'no-avatar.png'!!}" width="30" height="30">
                    <span class="username">{!! $profile->name !!}</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li style="width: 50% !important;"><a href="#"><i class="fa fa-bar-chart-o"></i>Thống kê bán hàng</a></li>
                    <li style="width: 50% !important;"><a href="{{ route('management.dashboard') }}"><i class="fa fa-th-list"></i> Quản lý</a></li>
                    <li><a href="{!! route('management.logout') !!}"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</header>