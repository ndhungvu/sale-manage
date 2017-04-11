@extends('layouts.manager')
@section('content')
<div class="col-lg-12 purchase-order-index">
  <section class="panel">
      <header class="panel-heading">Phiếu kiểm kho
        <div class="panel-tools">
                <a href="{{ route('management.stocktake.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Kiểm kho</a>

                <a href="{{ route('management.stocktake.export') }}" class="btn btn-sm btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</a>
            </div>
      </header>
      <div class="panel-body">
        <form class="form-horizontal filter-form-custom">
           <div class="form-group">

                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tìm kiếm</label>
                <div class="col-lg-10">
                    <input name="code" value="{{ $input::get('code') }}" style="margin-bottom:5px" type="text" class="form-control col-lg-2 col-sm-2" id="" placeholder="Mã phiếu nhập">
         
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
                          <label class="label_radio" for="radio-01">
                              <input name="status" id="radio-01" value="0" type="radio" @if( $input::get('status') == 0) checked @endif /> Phiếu tạm
                          </label>
                          <label class="label_radio" for="radio-02">
                              <input name="status" id="radio-02" value="1" type="radio" @if($input::get('status') == 1) checked @endif /> Đã cân bằng kho
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
                    <button type="submit" class="btn btn-primary">Lọc phiếu nhập</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="adv-table">
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Mã kiểm kho</th>
                    <th>Thời gian</th>
                    <th>Ngày CB kho</th>
                    <th>Tổng số lượng</th>
                    <th>Tổng chênh lệch</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                    @if($stockTakes->count())
                      @foreach($stockTakes as $stockTake)
                      <tr data-id="{{ $stockTake->id }}" class="gradeX old">
                          <td class="center">
                              <button class="jsShowProduct btn btn-xs btn-primary" attr-id="{{ $stockTake->id }}"><i class="fa fa-plus-square"></i></button>
                          </td>
                          <td>{{ $stockTake->code }}</td>
                          <td>{{ $stockTake->created_at }}</td>
                          <td>{{ $stockTake->balance_date }}</td>
                          <td>{{ number_format($stockTake->quantum) }}</td>
                          <td>{{ number_format($stockTake->quantum_diff) }}</td>
                          <td class="purchase-status">{{ $stockTake->getStatus() }}</td>
                      </tr>
                      <tr data-id="{{ $stockTake->id }}" class="disabled" attr-id="{{ $stockTake->id }}">
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
                                                        <textarea name="stockTake[note]" readonly="true" placeholder="Ghi chú..." class="form-control" rows="10">{{ trim($stockTake->note) }}</textarea>
                                                      </td>
                                                      <td>Mã kiểm kho</td>
                                                      <td><strong>{{ $stockTake->code }}</strong></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Thời gian</td>
                                                      <td>{{ $stockTake->created_at }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Ngày cân bằng</td>
                                                      <td>{{ $stockTake->balance_date }}</td>
                                                  </tr> 
                                                  <tr>
                                                      <td>Trạng thái</td>
                                                      <td class="purchase-status">{{ $stockTake->getStatus() }}</td>
                                                  </tr>
                                                  <tr>
                                                      <td>Người tạo</td>
                                                      <td>{{ $stockTake->getCreator() }}</td>
                                                  </tr>
                                                  </tbody>
                                              </table>

                                              <table class="table table-bordered table-striped table-condensed">
                                                  <thead>
                                                    <tr>
                                                        <th>Mã hàng hóa</th>
                                                        <th>Tên hàng hóa</th>
                                                        <th class="numeric">Tồn kho</th>
                                                        <th class="numeric">Kiểm thực tế</th>
                                                        <th class="numeric">Chênh lệch</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($stockTake->getCommodities() as $commodity)
                                                    <tr>
                                                        <td>{{ $commodity->getCommodityCode() }}</td>
                                                        <td>{{ $commodity->getCommodityName() }}</td>
                                                        <td class="numeric">{{ number_format($commodity->on_hand) }}</td>
                                                        <td class="numeric">{{ $commodity->quantum }}</td>
                                                        <td class="numeric">{{ number_format($commodity->quantum_diff) }}</td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                              </table>

                                              <table class="table table-bordered table-striped table-condensed">
                                                  <tbody>
                                                    <tr>
                                                        <td>Tổng số lượng</td>
                                                        <td><strong>{{ number_format($stockTake->quantum) }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tổng chênh lệch</td>
                                                        <td><strong>{{ number_format($stockTake->quantum_diff) }}</strong></td>
                                                    </tr>
                                                  </tbody>
                                              </table>
                                              <div style="text-align: right;">
                                                <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-sign-out"></i> Xuất  file</button>
                                                @if($stockTake->status != 2)
                                                <button data-code="{{ $stockTake->code }}" rel="{{ route('management.stocktake.postDelete',$stockTake->id) }}" type="button" class="btn btn-danger btn-delete-stocktake"><i class="fa fa-times"></i> Hủy bỏ</button>
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
              <?php echo $stockTakes->render(); ?>
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