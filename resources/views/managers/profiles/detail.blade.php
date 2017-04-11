@extends('layouts.manager')
@section('content')
<div class="row">
    <aside class="profile-nav col-lg-3">
        @include('managers.profiles.left');
    </aside>
    <aside class="profile-info col-lg-9">
        <section class="panel">             
            <div class="panel-body bio-graph-info">
                <h1>{!! $profile->name!!}</h1>
                <div class="row">
                    <div class="bio-row">
                        <p><span>Tên đăng nhập </span>: {!! $profile->nickname!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Email </span>: {!! $profile->email!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Địa chỉ </span>: {!! $profile->address!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Giới tính </span>: {!! $profile->gender = 1 ? 'Nam' : 'Nữ'!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Ngày sinh </span>: {!! $profile->birthday!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>CMND </span>: {!! $profile->cmnd!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Điện thoại </span>: {!! $profile->phone!!}</p>
                    </div>
                    <div class="bio-row">
                        <p><span>Di động </span>: {!! $profile->mobile!!}</p>
                    </div>                        
                </div>
                <div class="text-r-b-20">
                    <a href="{!! route('management.profile.edit') !!}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                </div>
            </div>
        </section>
    </aside>
</div>
@stop