@extends('layouts.manager')
@section('content')
<div class="col-lg-12 price-book" data-pricebook="{{ $pricebookid }}" data-link="{{ route('management.updatePriceProduct',NULL) }}" data-link-del="{{ route('management.PriceBook.delproduct',[NULL,NULL]) }}">
  <section class="panel">
      <header class="panel-heading">Bảng giá "<strong>{{ $pricebookname }}</strong>"
        <div class="panel-tools">
                <button data-toggle="modal" data-target=".bs-create-pricebook-modal-lg" class="btn btn-sm btn-primary"><i class="fa fa-plus-square"></i> Thêm bảng giá</button>
                <a href="{{ route('management.PriceBook.export',['book'=>$pricebookid]) }}"><button class="btn btn-sm btn-primary"><i class="fa fa fa-sign-in"></i> Xuất file</button></a>
            </div>
      </header>
      <div class="panel-body">
        <form class="form-horizontal filter-form-custom">
           <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Bảng giá</label>
                <div class="col-lg-10">
                    @if($pricebookid != null && $pricebookid != '')
                    <select name="book" class="form-control m-bot15 m-pricebook-list" style="float: left;width: 90%;">
                    @else
                    <select name="book" class="form-control m-bot15 m-pricebook-list">
                    @endif
                        <option value="">Bảng giá chung</option>
                            @foreach ($pricebooks as $pricebook)
                            <option @if($params->get('book') == $pricebook->id) selected @endif value="{{ $pricebook->id }}">{{ $pricebook->name }}</option>
                            @endforeach
                    </select>
                    @if($pricebookid != null && $pricebookid != '')
                    <button style="float: left;margin-left: 10px;" rel="{{ route('management.PriceBook.ajaxGet',$pricebookid) }}" type="button" data-id="{{ $pricebookid }}" class="btn btn-warning btn-update-price-book"><i class="fa fa-pencil-square-o"></i></button>
                    @endif
                </div>
            </div>
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
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-primary">Lọc hàng hóa</button>
                </div>
            </div>
        </form>
        <hr>
        <div class="adv-table">
            @if($pricebookid != '' && $pricebookid != null)
            <input data-link="{{ route('management.products.search') }}" id="inputProductAutoComplete" name="inputProductAutoComplete" placeholder="Thêm hàng hóa vào bảng giá | Tìm theo mã hoặc tên hàng hóa" type="text" class="form-control"></input>
            <br />
            @endif
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th>Mã hàng hóa</th>
                    <th>Tên hàng hóa</th>
                    <th>Giá vốn</th>
                    <th>Giá nhập cuối</th>
                    <th>Giá mới</th>
                    @if($pricebookid != null && $pricebookid != '')
                    <th></th>
                    @endif
                </tr>
                </thead>
                <tbody id="bodyListProducts">
                  @if($products->count())
                    @foreach($products as $product)
                    <tr data-id="{{ $product->id }}" class="gradeX old producthasid_{{ $product->id }}">
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->cost) }}</td>
                        <td>{{ number_format($product->last_price) }}</td>
                        <td><input data-pricebook="{{ $pricebookid }}" rel="{{ route('management.updatePriceProduct',$product->id) }}" data-id="{{ $product->id }}" name="new_price" type="text" class="form-control new_price_change" value="{{ $product->getPriceBook() }}" /></td>
                        @if($pricebookid != null && $pricebookid != '')
                        <td><button rel="{{ route('management.PriceBook.delproduct',[$product->id,$pricebookid]) }}" type="button" data-id="{{ $product->id }}" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button></td>
                        @endif
                    </tr>
                    @endforeach
                  @else
                  <tr class="no-item"><td colspan="6">Không tìm thấy kết quả nào phù hợp</td></tr>
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
<style type="text/css">
  #createPriceBookForm .radios {
    padding-top: 5px;
  }
  #createPriceBookForm .radios label {
    display: inline;
    margin-right: 20px;
    padding-left: 30px;
  }
}
</style>
<!-- create modal -->
<div class="modal fade bs-create-pricebook-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Thêm bảng giá</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('route' => 'management.PriceBook.create','id'=>'createPriceBookForm','class'=>'form-horizontal tasi-form', 'enctype'=>'multipart/form-data')) !!}
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Tên bảng giá</label>
                  <div class="col-sm-10">
                      <input name="name" type="text" class="form-control">
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Hiệu lực</label>
                  <div class="col-sm-10">
                      <div class="row">
                        <div class="col-xs-6">
                          <div class="input-group date form_datetime-adv">
                            <input name="start_date" type="text" class="form-control" placeholder="Từ ngày">
                            <div class="input-group-btn">
                                  <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                  <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button>
                              </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                          <div class="input-group date form_datetime-adv">
                            <input name="end_date" type="text" class="form-control" placeholder="Đến ngày">
                            <div class="input-group-btn">
                                  <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                                  <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button>
                              </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Trạng thái</label>
                  <div class="col-sm-10">
                    <div class="radios">
                          <label class="label_radio" for="radio-00">
                              <input name="status" id="radio-00" value="1" type="radio" checked /> Kích hoạt
                          </label>
                          <label class="label_radio" for="radio-01">
                              <input name="status" id="radio-01" value="0" type="radio"  /> Chưa áp dụng
                          </label>
                      </div>
                  </div>
              </div>
          {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btnSubmitFromPriceBookCreate"><i class="fa fa-floppy-o"></i> Lưu</button>
        <button  type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
      </div>
    </div>
  </div>
</div>

<!-- update modal -->
<div class="modal fade bs-update-pricebook-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cập nhật bảng giá</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button rel="{{ route('management.PriceBook.ajaxPost',null) }}" type="button" class="btn btn-success btnSubmitFromPriceBookUpdate"><i class="fa fa-floppy-o"></i> Lưu</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
        <button rel="{{ route('management.PriceBook') }}" type="button" class="btn btn-danger btnDeletePriceBook"><i class="fa fa-trash-o"></i> Xóa</button>
      </div>
    </div>
  </div>
</div>

@stop