@extends('layouts.manager')
@section('content')
<div class="col-lg-12 transfer-index">
  <section class="panel">
      <header class="panel-heading">Phiếu chuyển hàng
        <div class="panel-tools">
                <a href="{{ route('management.transfers.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Chuyển hàng</a>
                <a href="{{ route('management.transfers.export') }}" class="btn btn-sm btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</a>
            </div>
      </header>
      <div class="panel-body">
        <form class="form-horizontal filter-form-custom">
           <div class="form-group">

                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tìm kiếm</label>
                <div class="col-lg-10">
                    <input name="code" value="{{ $input::get('code') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Mã phiếu chuyển">
         
                    <input name="pcode" value="{{ $input::get('pcode') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Tên hoặc mã hàng">
          
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
                          <!-- <label class="label_radio" for="radio-01">
                              <input name="status" id="radio-01" value="0" type="radio" @if( $input::get('status') == 0) checked @endif /> Phiếu tạm
                          </label> -->
                          <label class="label_radio" for="radio-02">
                              <input name="status" id="radio-02" value="1" type="radio" @if($input::get('status') == 1) checked @endif /> Đã chuyển hàng
                          </label>
                          <label class="label_radio" for="radio-03">
                              <input name="status" id="radio-03" value="2" type="radio" @if($input::get('status') == 2) checked @endif /> Đã hủy
                          </label>
                      </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Loại phiếu</label>
                <div class="col-lg-10">
                    <div class="radios">
                          <label class="label_radio" for="radio-04">
                              <input name="type" id="radio-04" value="-1" type="radio" @if( $input::get('type') == -1) checked @endif /> Tất cả
                          </label>
                          <label class="label_radio" for="radio-05">
                              <input name="type" id="radio-05" value="1" type="radio" @if($input::get('type') == 1) checked @endif /> Chuyển đi
                          </label>
                          <label class="label_radio" for="radio-06">
                              <input name="type" id="radio-06" value="2" type="radio" @if($input::get('type') == 2) checked @endif /> Nhập về
                          </label>
                      </div>
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Thời gian chuyển</label>
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
                    <button type="submit" class="btn btn-primary">Lọc phiếu chuyển</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="adv-table">
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Mã chuyển hàng</th>
                    <th>Ngày chuyển</th>
                    <th>Từ chi nhánh</th>
                    <th>Tới chi nhánh</th>
                    <th>Giá trị chuyển</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                    @if($transfers->count())
                      @foreach($transfers as $transfer)
                      <tr data-id="{{ $transfer->id }}" class="gradeX old">
                          <td class="center">
                              <button class="jsShowProduct btn btn-xs btn-primary" attr-id="{{ $transfer->id }}"><i class="fa fa-plus-square"></i></button>
                          </td>
                          <td>{{ $transfer->code }}</td>
                          <td>{{ $transfer->transfer_date }}</td>
                          <td>{{ $transfer->getFromBranchName() }}</td>
                          <td>{{ $transfer->getToBranchName() }}</td>
                          <td>{{ number_format($transfer->total_money) }}</td>
                          <td class="purchase-status">{{ $transfer->getStatus() }}</td>
                      </tr>
                      <tr data-id="{{ $transfer->id }}" class="disabled" attr-id="{{ $transfer->id }}">
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
                                                        <textarea name="transfer[note]" @if($transfer->status == 2) disabled @endif placeholder="Ghi chú..." class="form-control" rows="10">{{ trim($transfer->note) }}</textarea>
                                                      </td>
                                                      <td>Mã chuyển hàng</td>
                                                      <td><strong>{{ $transfer->code }}</strong></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Ngày chuyển</td>
                                                      <td>
                                                        <input name="transfer[transfer_date]" type="text" class="form-control form_datetime" value="{{ $transfer->transfer_date }}" disabled />
                                                      </td>
                                                  </tr> 
                                                  <tr>
                                                      <td>Từ chi nhánh:</td>
                                                      <td>{{ $transfer->getFromBranchName() }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Tới chi nhánh</td>
                                                      <td>{{ $transfer->getToBranchName() }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Trạng thái</td>
                                                      <td class="purchase-status">{{ $transfer->getStatus() }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Người tạo</td>
                                                      <td> {{ $transfer->getCreator() }}</td>
                                                  </tr>
                                                  </tbody>
                                              </table>

                                              <table class="table table-bordered table-striped table-condensed">
                                                  <thead>
                                                    <tr>
                                                        <th>Mã hàng hóa</th>
                                                        <th>Tên hàng hóa</th>
                                                        <th class="numeric">Số lượng chuyển</th>
                                                        <th class="numeric">Giá chuyển/nhận</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($transfer->getCommodities() as $commodity)
                                                    <tr>
                                                        <td>{{ $commodity->getCommodityCode() }}</td>
                                                        <td>{{ $commodity->getCommodityName() }}</td>
                                                        <td class="numeric">{{ number_format($commodity->quantum) }}</td>
                                                        <td class="numeric">{{ number_format($commodity->transfer_money) }}</td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                              </table>

                                              <table class="table table-bordered table-striped table-condensed">
                                                  <tbody>
                                                    <tr>
                                                        <td>Tổng số mặt hàng</td>
                                                        <td><strong>{{ number_format($transfer->quantum) }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tổng cộng</td>
                                                        <td><strong>{{ number_format($transfer->total_money) }}</strong></td>
                                                    </tr>
                                                    
                                                  </tbody>
                                              </table>
                                              <div style="text-align: right;">
                                                @if($transfer->status == 1)
                                                <button rel="{{ route('management.transfers.postUpdate',$transfer->id) }}" type="button" class="btn btn-success btn-update-transfer"><i class="fa fa-floppy-o"></i> Cập nhật</button>
                                                <!-- <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-success"><i class="fa fa-reply-all"></i> Trả hàng</button> -->
                                                @endif
                                                <!-- <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-print"></i> In</button>
                                                <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-barcode"></i> In mã vạch</button>
                                                <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-sign-out"></i> Xuất  file</button> -->
                                                @if($transfer->status != 2)
                                                <button data-code="{{ $transfer->code }}" rel="{{ route('management.transfers.postDelete',$transfer->id) }}" type="button" class="btn btn-danger btn-delete-transfer"><i class="fa fa-times"></i> Hủy bỏ</button>
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
              <?php echo $transfers->render(); ?>
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