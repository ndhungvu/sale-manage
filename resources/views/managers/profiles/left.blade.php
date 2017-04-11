<section class="panel">
    <div class="user-heading round avatar">
        <a href="javascript:;">
            <img src="/uploads/avatars/{!! $profile->avatar or 'no-avatar.png'!!}" alt="{!! $profile->name !!}">
        </a>
        <button type="button" class="btn btn-primary btn-xs jsEditAvatar"><i class="fa fa-edit"></i></button>
        <h1>{!! $profile->name !!}</h1>
        <p>{!! $profile->email !!}</p>
    </div>
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="{!! route('management.profile') !!}"> <i class="fa fa-user"></i>Thông tin cá nhân</a></li>              
        <li><a href="{!! route('management.profile.edit') !!}"> <i class="fa fa-edit"></i> Cập nhật tài khoản</a></li>
        <li><a href="{!! route('management.profile.change-password') !!}"> <i class="fa fa-cog"></i> Thay đổi mật khẩu</a></li>
    </ul>
</section>