@extends('layouts.manager')
@section('content')
<div class="col-lg-12 damage-items-index">
  <section class="panel">
      <header class="panel-heading">Phiếu xuất hủy
        <div class="panel-tools">
                <a href="{{ route('management.damageitems.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Tạo phiếu</a>
                <!-- <button class="btn btn-sm btn-primary"><i class="fa fa fa-sign-in"></i> Import</button> -->
                <a href="{{ route('management.damageitems.export') }}" class="btn btn-sm btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</a>
            </div>
      </header>
      <div class="panel-body">
        <form class="form-horizontal filter-form-custom">
           <div class="form-group">

                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tìm kiếm</label>
                <div class="col-lg-10">
                    <input name="code" value="{{ $input::get('code') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Mã phiếu nhập">
         
                    <input name="pcode" value="{{ $input::get('pcode') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Tên hoặc mã hàng">
                  
                  
                    <input name="scode" value="{{ $input::get('scode') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Tên hoặc mã NCC">
                 
          
                    <input name="note" value="{{ $input::get('note') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Ghi chú">
                  
                    <select style="margin-bottom:5px" class="form-control" name="uname" >
                      <option value="">Người tạo</option>
                      @foreach($staffs as $staff)
                        <option value="{{$staff->id}}" @if($staff->id == $input::get('uname')) selected @endif>{{$staff->name}}</option>
                      @endforeach
                    </select>
                 
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Trạng thái</label>
                <div class="col-lg-10">
                    <div class="radios">
                          <label class="label_radio" for="radio-00">
                              <input name="status" id="radio-00" value="-1" type="radio" @if( $input::get('status') == -1) checked @endif /> Tất cả
                          </label>
                          <label class="label_radio" for="radio-01">
                              <input name="status" id="radio-01" value="0" type="radio" @if( $input::get('status') == 0) checked @endif /> Phiếu tạm
                          </label>
                          <label class="label_radio" for="radio-02">
                              <input name="status" id="radio-02" value="1" type="radio" @if($input::get('status') == 1) checked @endif /> Hoàn thành
                          </label>
                          <label class="label_radio" for="radio-03">
                              <input name="status" id="radio-03" value="2" type="radio" @if($input::get('status') == 2) checked @endif /> Đã hủy
                          </label>
                      </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Thời gian</label>
                <div class="col-lg-10">
                    <div style="padding-left:0" class="col-lg-6 col-sm-6">
                        <label>Từ ngày</label>
                        <div class="input-group date form_datetime-adv">
                            <input name="sdate" value="{{ $input::get('sdate') }}" type="text" class="form-control" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>

                    <div style="padding-left:0" class="col-lg-6 col-sm-6">
                        <label>Đến ngày</label>
                        <div class="input-group date form_datetime-adv">
                            <input name="edate" value="{{ $input::get('edate') }}" type="text" class="form-control" readonly="" size="16">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-primary">Lọc phiếu xuất hủy</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="adv-table">
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Mã trả xuất hủy</th>
                    <th>Thời gian</th>
                    <th>Chi nhánh</th>
                    <th>Tổng SL hủy</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                    @if($damageItems->count())
                      @foreach($damageItems as $damageItem)
                      <tr data-id="{{ $damageItem->id }}" class="gradeX old">
                          <td class="center">
                              <button class="jsShowProduct btn btn-xs btn-primary" attr-id="{{ $damageItem->id }}"><i class="fa fa-plus-square"></i></button>
                          </td>
                          <td>{{ $damageItem->code }}</td>
                          <td>{{ $damageItem->trans_date }}</td>
                          <td>{{ $damageItem->getBranchName() }}</td>
                          <td>{{ number_format($damageItem->quantum) }}</td>
                          <td class="purchase-status">{{ $damageItem->getStatus() }}</td>
                      </tr>
                      <tr data-id="{{ $damageItem->id }}" class="disabled" attr-id="{{ $damageItem->id }}">
                          <td class="details details-custom" colspan="7">
                              <section class="panel">
                                    <header class="panel-heading panel-heading-custom">
                                        <ul class="nav nav-tabs nav-justified ">
                                            <li class="active">
                                                <a href="#popular" data-toggle="tab">
                                                    Thông tin
                                                </a>
                                            </li>
                                        </ul>
                                    </header>
                                    <div class="panel-body">
                                        <div class="tab-content tasi-tab">
                                            <div class="tab-pane active" id="popular">
                                              <table class="table table-bordered">
                                                  <tbody>
                                                  <tr>
                                                      <td rowspan="6" style="width: 20%;">
                                                        <textarea name="damageItem[note]" @if($damageItem->status == 2) disabled @endif placeholder="Ghi chú..." class="form-control" rows="10">{{ trim($damageItem->note) }}</textarea>
                                                      </td>
                                                      <td>Mã nhập hàng</td>
                                                      <td><strong>{{ $damageItem->code }}</strong></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Thời gian</td>
                                                      <td><input name="damageItem[trans_date]" type="text" class="form-control form_datetime" value="{{ $damageItem->trans_date }}" @if($damageItem->status == 2) disabled @endif /></td>
                                                  </tr> 
                                                  <tr>
                                                      <td>Trạng thái</td>
                                                      <td class="purchase-status">{{ $damageItem->getStatus() }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Chi nhánh</td>
                                                      <td>{{ $damageItem->getBranchName() }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Người tạo</td>
                                                      <td>
                                                        <select class="form-control" name="damageItem[user_id]" @if($damageItem->status == 2) disabled @endif>
                                                          @foreach($staffs as $staff)
                                                            <option value="{{$staff->id}}" @if($staff->id == $damageItem->user_id) selected @endif>{{$staff->name}}</option>
                                                          @endforeach
                                                        </select>
                                                      </td>
                                                  </tr>
                                                  </tbody>
                                              </table>

                                              <table class="table table-bordered table-striped table-condensed">
                                                  <thead>
                                                    <tr>
                                                        <th>Mã hàng hóa</th>
                                                        <th>Tên hàng hóa</th>
                                                        <th class="numeric">SL Hủy</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($damageItem->getCommodities() as $commodity)
                                                    <tr>
                                                        <td>{{ $commodity->getCommodityCode() }}</td>
                                                        <td>{{ $commodity->getCommodityName() }}</td>
                                                        <td class="numeric">{{ $commodity->quantum }}</td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                              </table>

                                              <div style="text-align: right;">
                                                @if($damageItem->status == 1)
                                                <button rel="{{ route('management.damageitems.postUpdate',$damageItem->id) }}" type="button" class="btn btn-success btn-update-damageItem"><i class="fa fa-floppy-o"></i> Cập nhật</button>
                                                @endif
                                                <!-- <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-print"></i> In</button>
                                                <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-sign-out"></i> Xuất  file</button> -->
                                                @if($damageItem->status != 2)
                                                <button data-code="{{ $damageItem->code }}" rel="{{ route('management.damageitems.postDelete',$damageItem->id) }}" type="button" class="btn btn-danger btn-delete-damageItem"><i class="fa fa-times"></i> Hủy bỏ</button>
                                                @endif
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                          </td>                                             
                      </tr>
                      @endforeach
                    @else
                    <tr class="gradeX old">
                      <td colspan="7">Không tìm thấy kết quả nào phù hợp</td>
                    </tr> 
                    @endif
                </tbody>
            </table>
            <!--Pagination-->
            <div class="dataTables_paginate paging_bootstrap pagination">
              <?php echo $damageItems->render(); ?>
            </div>
        </div>
      </div>
  </section>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.jsShowProduct').on('click', function(){
          var _this = $(this);
          var _id = _this.attr('attr-id');
          
          if(_this.find('i').hasClass('fa-plus-square')) {
              $('table tr').each(function(index, item){
                  var _attr_id = $(item).attr('attr-id');
                  $(item).find('.jsShowProduct').html('<i class="fa fa-plus-square"></i>').removeClass('btn-danger').addClass('btn-primary');
                  $('tr[attr-id="'+ _attr_id +'"]').hide();
              });

              _this.html('<i class="fa fa-minus-square"></i>').removeClass('btn-primary').addClass('btn-danger');;
              $('tr[attr-id="'+ _id +'"]').show();
          }else {
              _this.html('<i class="fa fa-plus-square"></i>').removeClass('btn-danger').addClass('btn-primary');
              $('tr[attr-id="'+ _id +'"]').hide();
          }
      });
  });
</script>
@stop