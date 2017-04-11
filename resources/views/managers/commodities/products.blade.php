@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
  <section class="panel">
      <header class="panel-heading">Hàng hóa
        <div class="panel-tools">
                <button data-toggle="modal" data-target=".bs-create-product-modal-lg" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Thêm mới</button>
                <button data-toggle="modal" data-target=".bs-import-product-modal-lg" class="btn btn-sm btn-primary"><i class="fa fa-sign-in"></i> Import</button>
                <a href="{{ route('management.products.export') }}" class="btn btn-sm btn-primary"><i class="fa fa fa-file-text-o"></i> Xuất file</a>
            </div>
      </header>
      <div class="panel-body">
        <form class="form-horizontal filter-form-custom">
           <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Mã hàng | Tên hàng</label>
                <div class="col-lg-10">
                    <input name="code" type="text" class="form-control" id="inputEmail1" placeholder="" value="{{ $params->get('code') }}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Nhóm hàng</label>
                <div class="col-lg-10">
                    <select name="commodity_group" class="form-control m-bot15">
                        <option value="">---Lựa chọn---</option>
                            @foreach ($categories as $category)
                            <option @if($params->get('commodity_group') == $category['id']) selected @endif value="{{ $category['id'] }}">{{ $category['showName'] }}</option>
                              @if(!empty($category['childs']))
                                @foreach ($category['childs'] as $levelTwo)
                                  <option @if($params->get('commodity_group') == $levelTwo['id']) selected @endif value="{{ $levelTwo['id'] }}">{{ $levelTwo['showName'] }}</option>
                                    @if(!empty($levelTwo['childs']))
                                      @foreach ($levelTwo['childs'] as $leveThree)
                                        <option @if($params->get('commodity_group') == $leveThree['id']) selected @endif value="{{ $leveThree['id'] }}">{{ $leveThree['showName'] }}</option>
                                      @endforeach
                                    @endif
                                @endforeach
                              @endif
                            @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Tồn kho</label>
                <div class="col-lg-10">
                    <div class="radios">
                          <label class="label_radio" for="radio-01">
                              <input name="on_hand" id="radio-01" value="1" type="radio" @if($params->get('on_hand') == 1) checked @endif /> Dưới định mức tồn
                          </label>
                          <label class="label_radio" for="radio-02">
                              <input name="on_hand" id="radio-02" value="2" type="radio" @if($params->get('on_hand') == 2) checked @endif /> Vượt định mức tồn
                          </label>
                          <label class="label_radio" for="radio-03">
                              <input name="on_hand" id="radio-03" value="3" type="radio" @if($params->get('on_hand') == 3) checked @endif /> Còn hàng trong kho
                          </label>
                          <label class="label_radio" for="radio-04">
                              <input name="on_hand" id="radio-04" value="" type="radio" @if($params->get('on_hand') == null) checked @endif /> Không lọc tồn kho
                          </label>
                      </div>
                </div>
            </div>

            <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Lựa chọn hiển thị</label>
                <div class="col-lg-10">
                    <div class="radios">
                          <label class="label_radio" for="radio-001">
                              <input name="active_status" id="radio-001" value="" type="radio" @if($params->get('active_status') == null) checked @endif /> Tất cả
                          </label>
                          <label class="label_radio" for="radio-002">
                              <input name="active_status" id="radio-002" value="1" type="radio" @if($params->get('active_status') == 1) checked @endif /> Hàng ngừng Kinh doanh
                          </label>
                          <label class="label_radio" for="radio-003">
                              <input name="active_status" id="radio-003" value="2" type="radio" @if($params->get('active_status') == 2) checked @endif /> Hàng đang Kinh doanh
                          </label>
                      </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-primary">Lọc hàng hóa</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="adv-table">
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>
                    <th>Mã hàng hóa</th>
                    <th>Tên hàng hóa</th>
                    <th>Giá bán</th>
                    <th>Giá vốn</th>
                    <th>Tồn kho</th>
                </tr>
                </thead>
                <tbody>
                  @if($products->count())
                    @foreach($products as $product)
                    <tr data-id="{{ $product->id }}" class="gradeX old">
                        <td class="center">
                            <button class="jsShowProduct btn btn-xs btn-primary" attr-id="{{ $product->id }}"><i class="fa fa-plus-square"></i></button>
                        </td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->base_price) }}</td>
                        <td>{{ number_format($product->cost) }}</td>
                        <td>{{ $product->getOnHand() }}</td>
                    </tr>
                    <tr data-id="{{ $product->id }}" class="disabled" attr-id="{{ $product->id }}">
                        <td class="details details-custom" colspan="6">
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
                                                    <td rowspan="6" style="width: 20%;"><img style="width: 180px; margin-top:5px;" src="{{ $product->getImage() }}"></td>
                                                    <td colspan="2">
                                                      @if($product->allows_sale == 1)
                                                        <p><i style="color: green" class="fa fs16 fa-check txtGreen"></i> <span class="txtB ng-binding">Được bán trực tiếp</span></p>
                                                      @else
                                                        <p><i class="fa fs16 fa-check txtGreen"></i> <span class="txtB ng-binding">Không được bán trực tiếp</span></p>
                                                      @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mã hàng hóa</td>
                                                    <td><strong>{{ $product->code }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>Nhóm hàng</td>
                                                    <td>{{ $product->getCategoryNameFromArrCategories($categorienames) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Định mức tồn</td>
                                                    <td>{{ $product->min_quantity }}  > {{ $product->max_quantity }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Giá bán</td>
                                                    <td>{{ $product->base_price }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Giá vốn</td>
                                                    <td>{{ $product->cost }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                              <button rel="{{ route('management.updateProduct',$product->id) }}" type="button" class="btn btn-success btn-update-product"><i class="fa fa-plus-square"></i> Cập nhật</button>
                                              <!-- <button onclick="alert('Chức năng đang cập nhật')" type="button" class="btn btn-primary"><i class="fa fa-barcode"></i> In mã vạch</button> -->
                                              <button rel="{{ route('management.deleteProduct',$product->id) }}" type="button" class="btn btn-danger btn-delete-product"><i class="fa fa-trash"></i> Xóa</button>
                                              @if($product->status == 0)
                                              <button rel="{{ route('management.updateStatusProduct',$product->id) }}" type="button" class="btn btn-warning btn-update-inactive-status-product"><i class="fa fa-lock"></i> Ngừng kinh doanh</button>
                                              @else
                                              <button rel="{{ route('management.updateStatusProduct',$product->id) }}" type="button" class="btn btn-success btn-update-active-status-product"><i class="fa fa-check"></i> Cho phép kinh doanh</button>
                                              @endif
                                          </div>                                          
                                      </div>
                                  </div>
                              </section>
                        </td>                                             
                    </tr>
                    @endforeach
                  @else
                  <tr><td colspan="6">Không tìm thấy kết quả nào phù hợp</td></tr>
                  @endif
                </tbody>
            </table>
            <!--Pagination-->
            <div class="dataTables_paginate paging_bootstrap pagination">
              <?php echo $products->render(); ?>
            </div>
        </div>
      </div>
  </section>
</div>
<!-- create modal -->
<div class="modal fade bs-create-product-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Thêm hàng hóa</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route' => 'management.postProduct','id'=>'createProductForm','class'=>'form-horizontal tasi-form', 'enctype'=>'multipart/form-data')) !!}
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Mã hàng hóa</label>
                  <div class="col-sm-10">
                      <input name="code" type="text" class="form-control" placeholder="Mã hàng tự động">
                      <span class="help-block">Mã hàng hóa là thông tin duy nhất.</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Tên hàng hóa</label>
                  <div class="col-sm-10">
                      <input name="name" type="text" class="form-control">
                      <span class="help-block">Tên hàng hóa là tên của sản phẩm.</span>
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Nhóm hàng</label>
                  <div class="col-sm-10">
                      <!-- <div class="col-xs-8" style="padding-left: 0;"> -->
                        <select name="commodity_group_id" class="form-control">
                          <option value="">---Lựa chọn---</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['showName'] }}</option>
                              @if(!empty($category['childs']))
                                @foreach ($category['childs'] as $levelTwo)
                                  <option value="{{ $levelTwo['id'] }}">{{ $levelTwo['showName'] }}</option>
                                    @if(!empty($levelTwo['childs']))
                                      @foreach ($levelTwo['childs'] as $leveThree)
                                        <option value="{{ $leveThree['id'] }}">{{ $leveThree['showName'] }}</option>
                                      @endforeach
                                    @endif
                                @endforeach
                              @endif
                            @endforeach
                        </select>
                      <!-- </div> -->
                      <!-- <div class="col-xs-2">
                      <button type="button" class="btn btn-success btn-add-category"><i class="fa fa-plus"></i></button>
                      </div> -->
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Giá bán</label>
                  <div class="col-sm-10">
                      <input name="base_price" type="text" class="form-control" value="0">
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Giá vốn</label>
                  <div class="col-sm-10">
                      <input name="cost" type="text" class="form-control" value="0">
                      <span class="help-block">Giá vốn dùng để tính lợi nhuận cho sản phẩm (sẽ tự động thay đổi khi thay đổi phương pháp tính giá vốn).</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Tồn kho</label>
                  <div class="col-sm-10">
                      <input name="on_hand" type="text" class="form-control" value="0">
                      <span class="help-block">Số lượng tồn kho của sản phẩm (sẽ tự động tạo ra phiếu kiểm kho cho sản phẩm).</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Lựa chọn khác</label>
                  <div class="col-sm-10">
                    <input name="allows_sale" value="1" type="checkbox"> Được bán trực tiếp
                    <span class="help-block">Sản phẩm sẽ xuất hiện trên màn hình bán hàng.</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Đơn vị tính</label>
                  <div class="col-sm-10">
                      <input name="dvt" type="text" class="form-control" placeholder="Cái, Chiếc, Hộp, Lóc, Thùng,...">
                  </div>
              </div>


              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Thiết lập Định mức tồn</label>
                  <div class="col-sm-10">
                      <div class="row">
                        <div class="col-xs-4">
                          <label>Ít nhất</label>
                          <input name="min_quantity" type="text" class="form-control" value="0">
                        </div>
                        <div class="col-xs-4">
                          <label>Nhiều nhất</label>
                          <input name="max_quantity" type="text" class="form-control" value="999999999">
                        </div>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Hình ảnh</label>
                  <div class="col-sm-10">
                    <input type="file" name="image">
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Mô tả</label>
                  <div class="col-sm-10">
                      <textarea name="description" class="form-control"></textarea>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Mẫu ghi chú đặt hàng</label>
                  <div class="col-sm-10">
                      <textarea name="order_template" class="form-control"></textarea>
                  </div>
              </div>
              <input type="hidden" name="formType" id="createProductFormType" value="0" />
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btnSubmitFromProductCreate"><i class="fa fa-floppy-o"></i> Lưu</button>
        <button type="button" class="btn btn-primary btnSubmitFromProductCreateMore"><i class="fa fa-floppy-o"></i> Lưu & Thêm mới</button>
        <button  type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
      </div>
    </div>
  </div>
</div>

<!-- update modal -->
<div class="modal fade bs-update-product-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cập nhật hàng hóa</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btnSubmitFromProductUpdate"><i class="fa fa-floppy-o"></i> Lưu</button>
        <button  type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
      </div>
    </div>
  </div>
</div>

<!-- Import modal -->
<div class="modal fade bs-import-product-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nhập hàng hóa từ File dữ liệu</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route' => 'management.importProduct','id'=>'inportProductForm','class'=>'form-horizontal tasi-form', 'enctype'=>'multipart/form-data')) !!}
              <div class="form-group">
                  <div class="col-sm-12">
                      <h4>Xử lý dữ liệu (Tải về File mẫu: <a href="{{$sampleFileLink}}">Excel</a>)</h4>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Chọn file dữ liệu</label>
                  <div class="col-sm-10">
                    <input type="file" name="file_import">
                  </div>
              </div>
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button onclick="$(this).attr('disabled',true); $(this).find('span').html('Đang import dữ liệu...'); $('#inportProductForm').submit();" type="button" class="btn btn-success btnSubmitFromProductImport"><i class="fa fa-floppy-o"></i> <span>Import</span></button>
        <button  type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
      </div>
    </div>
  </div>
</div>

<div id="AddCategoryDialog" title="Thêm nhóm hàng" style="display: none;">
  <form role="form">
      <div class="form-group">
          <label for="name">Tên nhóm</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="">
      </div>
      <div class="form-group">
          <label for="parent">Nhóm cha</label>
          <select class="form-control" id="parent" name="parent">
            <option value="0">---Lựa chọn---</option>
            @foreach ($categories as $category)
            <option value="{{ $category['id'] }}">{{ $category['showName'] }}</option>
              @if(!empty($category['childs']))
                @foreach ($category['childs'] as $levelTwo)
                  <option value="{{ $levelTwo['id'] }}">{{ $levelTwo['showName'] }}</option>
                    @if(!empty($levelTwo['childs']))
                      @foreach ($levelTwo['childs'] as $leveThree)
                        <option value="{{ $leveThree['id'] }}">{{ $leveThree['showName'] }}</option>
                      @endforeach
                    @endif
                @endforeach
              @endif
            @endforeach
          </select>
      </div>
      <div class="form-goup">
        <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
        <button type="button" class="btn btn-default"><i class="fa fa-ban"></i>Bỏ qua</button>
      </div>
  </form>
</div>

<script type="text/javascript">
    var addMore = '{!! $addMore !!}';
    $(document).ready(function(){
        var dialog = $( "#AddCategoryDialog" ).dialog({
            autoOpen: false,
            height: 'auto',
            width: 500
        });

        $(document).on( "click", '.btn-add-category', function() {
          dialog.dialog( "open" );
        });

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

        if(addMore == 1){
          $(".bs-create-product-modal-lg").modal('show');
        }
    });
</script>
@stop