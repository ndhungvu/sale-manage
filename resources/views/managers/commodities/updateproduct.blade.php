{!! Form::open(array('route' => ['management.postUpdateProduct',$id],'id'=>'updateProductForm','class'=>'form-horizontal tasi-form', 'enctype'=>'multipart/form-data')) !!}
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Mã hàng hóa</label>
                  <div class="col-sm-10">
                      <input name="code" type="text" class="form-control" value="{{ $model->code }}">
                      <span class="help-block">Mã hàng hóa là thông tin duy nhất.</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Tên hàng hóa</label>
                  <div class="col-sm-10">
                      <input name="name" type="text" class="form-control" value="{{ $model->name }}">
                      <span class="help-block">Tên hàng hóa là tên của sản phẩm.</span>
                  </div>
              </div>
              
              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Nhóm hàng</label>
                  <div class="col-sm-10">
                      
                        <select name="commodity_group_id" class="form-control">
                          <option value="">---Lựa chọn---</option>
                            @foreach ($categories as $category)
                            <option @if($category['id'] == $model->commodity_group_id) selected @endif value="{{ $category['id'] }}">{{ $category['showName'] }}</option>
                              @if(!empty($category['childs']))
                                @foreach ($category['childs'] as $levelTwo)
                                  <option @if($levelTwo['id'] == $model->commodity_group_id) selected @endif value="{{ $levelTwo['id'] }}">{{ $levelTwo['showName'] }}</option>
                                    @if(!empty($levelTwo['childs']))
                                      @foreach ($levelTwo['childs'] as $leveThree)
                                        <option @if($leveThree['id'] == $model->commodity_group_id) selected @endif value="{{ $leveThree['id'] }}">{{ $leveThree['showName'] }}</option>
                                      @endforeach
                                    @endif
                                @endforeach
                              @endif
                            @endforeach
                        </select>
                      
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Giá bán</label>
                  <div class="col-sm-10">
                      <input name="base_price" type="text" class="form-control" value="{{ $model->base_price }}">
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Giá vốn</label>
                  <div class="col-sm-10">
                      <input name="cost" type="text" class="form-control" value="{{ $model->cost }}">
                      <span class="help-block">Giá vốn dùng để tính lợi nhuận cho sản phẩm (sẽ tự động thay đổi khi thay đổi phương pháp tính giá vốn).</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Tồn kho</label>
                  <div class="col-sm-10">
                      <input name="on_hand" type="text" class="form-control" value="{{ $model->getOnHand() }}">
                      <span class="help-block">Số lượng tồn kho của sản phẩm (sẽ tự động tạo ra phiếu kiểm kho cho sản phẩm).</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Lựa chọn khác</label>
                  <div class="col-sm-10">
                    <input @if($model->allows_sale ==1) checked @endif name="allows_sale" value="1" type="checkbox"> Được bán trực tiếp
                    <span class="help-block">Sản phẩm sẽ xuất hiện trên màn hình bán hàng.</span>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Đơn vị tính</label>
                  <div class="col-sm-10">
                      <input name="dvt" type="text" class="form-control" value="{{ $model->dvt }}" placeholder="Cái, Chiếc, Hộp, Lóc, Thùng,...">
                  </div>
              </div>


              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Thiết lập Định mức tồn</label>
                  <div class="col-sm-10">
                      <div class="row">
                        <div class="col-xs-4">
                          <label>Ít nhất</label>
                          <input name="min_quantity" type="text" class="form-control" value="{{ $model->min_quantity }}">
                        </div>
                        <div class="col-xs-4">
                          <label>Nhiều nhất</label>
                          <input name="max_quantity" type="text" class="form-control" value="{{ $model->max_quantity }}">
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
                      <textarea name="description" class="form-control">{{ $model->description }}</textarea>
                  </div>
              </div>

              <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">Mẫu ghi chú đặt hàng</label>
                  <div class="col-sm-10">
                      <textarea name="order_template" class="form-control">{{ $model->order_template }}</textarea>
                  </div>
              </div>
              <input type="hidden" name="formType" id="createProductFormType" value="0" />
          {!! Form::close() !!}