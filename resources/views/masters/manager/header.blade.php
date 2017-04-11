 <?php $profile = Auth::user();?>
 <header class="header white-bg">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="fa fa-bars"></span>
        </button>
        <!--logo start-->
        <a href="{{ route('management.dashboard') }}" class="logo" >Sales<span>Manager</span></a>
        <!--logo end-->
        <div class="horizontal-menu navbar-collapse collapse " style="margin-left: 0px;">
            <ul class="nav navbar-nav">
                <!--<li><a href="{{ route('management.dashboard') }}">Tổng quan</a></li>-->
                <li class="dropdown">
                    <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-archive"></i>Hàng hóa <b class=" fa fa-angle-down"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('management.products') }}">Danh mục</a></li>
                        <li><a href="{{ route('management.PriceBook') }}">Thiết lập giá</a></li>
                        <li><a href="{{ route('management.StockTakes') }}">Kiểm kho</a></li>
                        <li><a href="{{ route('management.products.groups') }}">Nhóm hàng</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-exchange"></i>Giao dịch <b class=" fa fa-angle-down"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('management.sales') }}">Hóa đơn</a></li>
                        <li><a href="{{ route('management.PriceBook') }}">Trả hàng</a></li>
                        <li><a href="{{ route('management.purchaseorder.index') }}">Nhập hàng</a></li>
                        <li><a href="{{ route('management.purchasereturn.index') }}">Trả hàng nhập</a></li>
                        <li><a href="{{ route('management.transfers.index') }}">Chuyển hàng</a></li>
                        <li><a href="{{ route('management.damageitems.index') }}">Xuất hủy</a></li>                       
                    </ul>
                </li>
                @if($profile->role_id ==2 )
                <li><a href="{{ route('management.staffs') }}"><i class="fa fa-group"></i>Nhân viên</a></li>
                @endif
                <li class="dropdown">
                    <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-group"></i>Đối tác <b class=" fa fa-angle-down"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('management.customers') }}">Khách hàng</a></li>
                        <li><a href="{{ route('management.suppliers') }}">Nhà cung cấp</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-bar-chart-o"></i></i>Báo cáo <b class=" fa fa-angle-down"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('management.reports.endday') }}">Cuối ngày</a></li>
                        <li><a href="{{ route('management.reports.sale') }}">Bán hàng</a></li>
                        <!-- <li><a href="{{ route('management.reports.order') }}">Đặt hàng</a></li>                        
                        <li><a href="{{ route('management.reports.product') }}">Nhập hàng</a></li>
                        
                        <li><a href="{{ route('management.reports.supplier') }}">Nhà cung cấp</a></li>--> 
                        <li><a href="{{ route('management.reports.customer') }}">Khách hàng</a></li>
                        <li><a href="{{ route('management.reports.staff') }}">Nhân viên</a></li>                  
                        <li><a href="{{ route('management.reports.financial') }}">Tài chính</a></li> 
                    </ul>
                </li>                
            </ul>
        </div>

        <div class="top-nav ">
            <ul class="nav pull-right top-menu">
                <li class="dropdown">
                    <?php $branchs = Session::get('company_branches'); $current_branch = Session::get('current_branch')?>
                    @if(!empty($branchs))
                    <a style="padding: 12px;" data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="username">{!! str_limit($branchs[$current_branch]['name'],15) !!}</span>
                        <b class="caret"></b>
                    </a>
                    @endif
                    @if($profile->role_id  != 3)
                    <ul class="dropdown-menu extended">
                        <div class="log-arrow-up"></div>
                        @if(Session::has('company_branches'))
                        @foreach(Session::get('company_branches') as $branch)
                        <li><a href="{{ route('management.changebranch', $branch['id']) }}"><i class="fa fa-chevron-circle-right"></i> {{ $branch['name'] }}</a></li>
                        @endforeach
                        @endif
                    </ul>
                    @endif
                </li>
                @if(Session::has('current_branch') && Session::get('current_branch') == $profile->branch_id)
                <li><a href="{{ route('sale') }}" class="btn btn-primary"><button type="button" class="btn btn-primary">Bán hàng</button></a></li>
                @endif
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="Avatar" src="/uploads/avatars/{!! $profile->avatar or 'no-avatar.png'!!}" width="30" height="30">
                        <span class="username">{!! str_limit($profile->name, 15) !!}</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <div class="log-arrow-up"></div>
                        <li><a href="{!! route('management.profile') !!}"><i class=" fa fa-suitcase"></i>Thông tin tài khoản</a></li>
                        <li><a href="{!! route('management.profile.change-password') !!}"><i class="fa fa-cog"></i>Thay đổi mật khẩu</a></li>
                        <li><a href="{!! route('management.logout') !!}"><i class="fa fa-sign-out"></i>Thoát</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->
            </ul>
        </div>
    </div>
</header>