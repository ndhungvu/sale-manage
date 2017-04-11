{!! Form::open(array('route' => ['management.PriceBook.ajaxPost', $pricebook->id],'id'=>'updatePriceBookForm','class'=>'form-horizontal tasi-form', 'enctype'=>'multipart/form-data')) !!}
  <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label">Tên bảng giá</label>
      <div class="col-sm-10">
          <input name="name" type="text" class="form-control" value="{{ $pricebook->name }}">
      </div>
  </div>
  <div class="form-group">
      <label class="col-sm-2 col-sm-2 control-label">Hiệu lực</label>
      <div class="col-sm-10">
          <div class="row">
            <div class="col-xs-6">
              <div class="input-group date form_datetime-adv">
                <input name="start_date" type="text" class="form-control" placeholder="Từ ngày" value="{{ $pricebook->start_date }}">
                <div class="input-group-btn">
                      <button type="button" class="btn btn-danger date-reset"><i class="fa fa-times"></i></button>
                      <button type="button" class="btn btn-warning date-set"><i class="fa fa-calendar"></i></button>
                  </div>
                </div>
            </div>
            <div class="col-xs-6">
              <div class="input-group date form_datetime-adv">
                <input name="end_date" type="text" class="form-control" placeholder="Đến ngày" value="{{ $pricebook->end_date }}">
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
            <input name="status" id="radio-00" value="1" type="radio" @if($pricebook->status == 1) checked @endif /> Kích hoạt
            <input name="status" id="radio-01" value="0" type="radio"  @if($pricebook->status == 0) checked @endif /> Chưa áp dụng
          </div>
      </div>
  </div>
{!! Form::close() !!}