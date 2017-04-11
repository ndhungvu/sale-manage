@extends('layouts.manager')
@section('content')
<style type="text/css">
  .damage-items-create .form-horizontal.tasi-form .form-group {
      border-bottom: 1px solid #eff2f7;
      padding-bottom: 15px;
      margin-bottom: 15px;
  }
</style>
<div class="row damage-items-create">
	{!! Form::open(array('route' => 'management.damageitems.postCreate','id'=>'createdamageItemsForm','class'=>'form-horizontal tasi-form')) !!}
      <div class="col-lg-8">
          <section class="panel">
              <header class="panel-heading">
                  Nhập hàng <input data-link="{{ route('management.products.search') }}" id="inputProductAutoComplete" name="inputProductAutoComplete" placeholder="Tìm hàng hóa theo mã hoặc tên" type="text" class="form-control"></input>
                  <span class="tools pull-right">
                    <a class="icon-chevron-down" href="javascript:;"></a>
                    <a class="icon-remove" href="javascript:;"></a>
                </span>
              </header>
              <div class="panel-body profile-activity" style="padding: 0">
              	<table class="table table-striped table-advance table-hover">
                  <thead>
                  <tr>
                      <th>Mã hàng hóa</th>
                      <th class="hidden-phone">Tên hàng hóa</th>
                      <th>SL Hủy</th>
                      <th></th>
                  </tr>
                  </thead>
                  <tbody id="bodyListProducts">
                  	<tr class="no-item"><td colspan="7">Không tìm thấy kết quả nào phù hợp</td></tr>
                  </tbody>
              </table>
              </div>
          </section>
      </div>
      <div class="col-lg-4">
          <section class="panel">
              <header class="panel-heading">
                  Thông tin
                  <span class="tools pull-right">
                    <a class="icon-chevron-down" href="javascript:;"></a>
                    <a class="icon-remove" href="javascript:;"></a>
                </span>
              </header>
              <div class="panel-body">
                  <section class="panel">
                      <header class="panel-heading tab-bg-dark-navy-blue">
                          <ul class="nav nav-tabs nav-justified ">
                              <li class="active">
                                  <a href="#popular" data-toggle="tab">
                                      Thông tin
                                  </a>
                              </li>
                              <li class="">
                                  <a href="#comments" data-toggle="tab">
                                      Mở rộng
                                  </a>
                              </li>
                              <li class="">
                                  <a href="#recent" data-toggle="tab">
                                      Ghi chú
                                  </a>
                              </li>
                          </ul>
                      </header>
                      <div class="panel-body">
                          <div class="tab-content tasi-tab">
                              <div class="tab-pane active" id="popular">
                                  <div class="form-group">
                                      <label class="col-sm-4 col-sm-4 control-label">Trạng thái</label>
                                      <div class="col-sm-8">
                                          <input type="text" class="form-control" disabled="disabled" value="Phiếu tạm" />
                                      </div>
                                  </div>
                                   <div class="form-group">
                                      <label class="col-sm-5 col-sm-5 control-label">Tổng SL hủy</label>
                                      <div class="col-sm-7">
                                          <label class="control-label" id="quantum">0</label>
                                          <input type="hidden" name="damageItem[quantum]" value="0" />
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-sm-4 control-label">Mã xuất hủy</label>
                                      <div class="col-sm-8">
                                          <input disabled="disabled" type="text" class="form-control" placeholder="Mã phiếu tự động" />
                                      </div>
                                  </div>
                              </div>
                              <div class="tab-pane" id="comments">
                                  <div class="form-group">
                                      <label class="col-sm-4 col-sm-4 control-label">Người tạo</label>
                                      <div class="col-sm-8">
                                          <select class="form-control" name="damageItem[user_id]">
                                          	@foreach($staffs as $staff)
                                          		<option value="{{$staff->id}}" @if($staff->id == $currentUserID) selected @endif>{{$staff->name}}</option>
                                          	@endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label class="col-sm-4 col-sm-4 control-label">Ngày tạo</label>
                                      <div class="col-sm-8">
                                          <input name="damageItem[trans_date]" type="text" class="form-control form_datetime" placeholder="Y-mm-dd H:i:s" />
                                      </div>
                                  </div>
                              </div>
                              <div class="tab-pane" id="recent">
                                  <div class="form-group">
                                    <textarea name="damageItem[note]" class="form-control" rows="4" placeholder="Ghi chú"></textarea>
                                  </div>
                              </div>
                              <div class="form-group" style="text-align: center;">
                                    <button onclick='window.location.href="{{ route('management.damageitems.index')}}"' type="button" class="btn btn-primary">Trở về</button>
                                    <button type="submit" class="btn btn-success">Hoàn thành</button>
                                </div>
                          </div>
                      </div>
                  </section>
              </div>
          </section>
      </div>
    {!! Form::close() !!}
  </div>
@stop