<section class="panel">
    <div class="user-heading round avatar">
        <a href="javascript:;">
            <img src="{!! $profile->image or '/uploads/avatars/no-avatar.png'!!}" alt="{!! $profile->name !!}">
        </a>
        <button type="button" class="btn btn-primary btn-xs jsEditAvatar"><i class="fa fa-edit"></i></button>
        <h1>{!! $profile->name !!}</h1>
        <p>{!! $profile->email !!}</p>
    </div>
    <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="{!! route('admin.profile') !!}"> <i class="fa fa-user"></i>Thông tin cá nhân</a></li>              
        <li><a href="{!! route('admin.profile.edit') !!}"> <i class="fa fa-edit"></i> Cập nhật tài khoản</a></li>
        <li><a href="{!! route('admin.profile.change-password') !!}"> <i class="fa fa-cog"></i> Thay đổi mật khẩu</a></li>
    </ul>
</section>