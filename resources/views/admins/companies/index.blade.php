@extends('layouts.admin')
@section('content')
<div class="col-lg-12">
  <section class="panel">
      <header class="panel-heading">công ty</header>
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('masters.message')
            </div>
        </div>
      <div class="panel-body">
        <!--Search-->
        {!! Form::open(array('id'=>'search','method'=>'GET', 'class'=>'form-horizontal filter-form-custom')) !!}
           <div class="form-group">
                <label for="inputEmail1" class="col-lg-2 control-label">Tên | Điện thoại</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="search" value="{!! !empty($_GET['search']) ? $_GET['search'] : '' !!}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Ngày tạo</label>
                <div class="col-lg-3">
                    <label class="col-lg-4 control-label">Từ ngày</label>
                    <div class="col-lg-8">
                        <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                            <input type="text" size="16" class="form-control" name="time_from" value="{!! !empty($_GET['time_from']) ? $_GET['time_from'] : '' !!}">
                            <span class="input-group-btn add-on">
                                <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                      </div>
                    </div>              
                </div>
                <div class="col-lg-3">
                    <label class="col-lg-4 control-label">Đến ngày</label>
                    <div class="col-lg-8">
                        <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                            <input type="text" size="16" class="form-control" name="time_to" value="{!! !empty($_GET['time_to']) ? $_GET['time_to'] : '' !!}">
                            <span class="input-group-btn add-on">
                                <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            </div>
        {!! Form::close() !!}  
        <!--End search-->
        <hr>        
        <div class="adv-table">
            <div class="text-r-b-20">
                <button class="btn btn-primary" data-toggle="modal" href="#create"><i class="fa fa-plus-square"></i> Thêm mới</button>               
            </div>
            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                <tr>                    
                    <th class="sorting_disabled"></th>                    
                    <th>Tên công ty</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th class="w-150">Hạn dùng (ngày)</th>
                </tr>
                </thead>
                <tbody>
                    @if(!empty($companies) && count($companies) > 0)
                        @foreach($companies as $key => $company)
                        <tr class="gradeX old" attr-key-old="<?=$key?>">
                            <td class="center">
                                <button class="jsShow btn btn-xs btn-primary" attr-key="<?=$key?>"><i class="fa fa-plus-square"></i></button>
                            </td>
                            <td>{!! $company->name !!}</td>
                            <td>{!! $company->mobile !!}</td>
                            <td>{!! $company->email !!}</td>
                            <td>{!! $company->address !!}</td>
                            <?php
                            $now = time();
                            $date_close = strtotime($company->date_close);
                            $date = $date_close - $now;
                            $days = floor($date / (60 * 60 * 24));
                            ?>
                            <td class="center">{!! $days >= 0 ? $days : 'Hết hạn' !!}</td>
                        </tr>
                        <tr class="disabled" attr-key="<?=$key?>">
                            <td class="details" colspan="6">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#home_{!! $key !!}" aria-controls="home" role="tab" data-toggle="tab">Thông tin</a></li>
                                    <li role="presentation"><a href="#history_{!! $key !!}" aria-controls="profile" role="tab" data-toggle="tab">Chi nhánh</a></li>
                                </ul>                               
                                <div class="tab-content js-detail">
                                    <div role="tabpanel" class="tab-pane active row" id="home_{!! $key !!}">
                                        <div class="col-lg-12">                                        
                                            <div class="col-lg-6">                                                
                                                <p><label class="col-lg-4">Tên công ty</label>{!! $company->name !!}</p>
                                                <p><label class="col-lg-4">Email</label>{!! $company->email !!}</p>                                                
                                                <p><label class="col-lg-4">Địa chỉ</label>{!! $company->address !!}</p>                                            
                                            </div>
                                            <div class="col-lg-6">
                                                <p><label class="col-lg-4">Điện thoại</label> {!! $company->phone !!}</p>
                                                <p><label class="col-lg-4">Di động</label> {!! $company->mobile !!}</p>
                                                <p><label class="col-lg-4">Hạn dùng</label>{!! $days >= 0 ? $days.' (ngày)' : 'Hết hạn' !!}</p>
                                            </div>                                                                               
                                        </div>
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary" data-toggle="modal" href="#edit_{!! $key !!}"><i class="fa fa-edit"></i>Cập nhật</button>
                                            <a href="javascript:void();" attr-key="<?=$key?>" attr-href="/admin/companies/delete/{!! $company->id !!}" class="btn btn-danger jsDelete">Xóa</a>                                        
                                        </div>
                                        <!-- Edit -->
                                        <div class="modal fade" id="edit_{!! $key !!}" tabindex="-1" role="dialog" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                              <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Cập nhật công ty</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(array('route'=>['admin.companies.edit', $company->id],'id'=>'frmEdit_'.$key,'class'=>'form-horizontal filter-form-custom frmEdit')) !!}
                                                            <form class="form-horizontal" role="form">
                                                            <div class="form-group">                       
                                                                <label class="col-lg-2 col-sm-2 control-label">Tên công ty<span class="required">*</span></label>
                                                                <div class="col-lg-10">
                                                                    <input type="text" class="form-control" name="name" value="{!! $company->name !!}">
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Email</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="email" value="{!! $company->email !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="address" value="{!! $company->address !!}">
                                                                </div>                                                                
                                                            </div>                                                           
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="phone" value="{!! $company->phone !!}">
                                                                </div>
                                                                <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control" name="mobile" value="{!! $company->mobile !!}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-lg-2 col-sm-2 control-label">Ngày hết hạn</label>
                                                                <div class="col-lg-4">
                                                                    <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                                                                        <input type="text" size="16" class="form-control" name="date_close" value="<?=date('Y-m-d', strtotime($company->date_close));?>">
                                                                        <span class="input-group-btn add-on">
                                                                            <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                                                        </span>
                                                                  </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-lg-12">
                                                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                                                                </div>
                                                            </div>
                                                        {!! Form::close() !!}    
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                        <!-- End Edit -->                               
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="history_{!! $key !!}">
                                        <div class="text-r-b-20">
                                            <button class="btn btn-primary createBranch" data-toggle="modal" href="#createBranch" attr-action="{!! route('admin.companies.branches.create',$company->id)  !!}"><i class="fa fa-plus-square"></i></button>                                            
                                        </div>
                                        <?php $branches =  $company->branches;?>
                                        @if(!empty($branches))
                                        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                                            <thead>
                                                <tr>                  
                                                    <th>Tên chi nhánh</th>
                                                    <th>Địa chỉ</th>
                                                    <th>Điện thoại</th>
                                                    <th>Di động</th>
                                                    <th></th>                                                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($branches as $k => $branch)
                                                <tr>
                                                    <td>{!! $branch->name; !!}</td>
                                                    <td>{!! $branch->address; !!}</td>
                                                    <td>{!! $branch->phone; !!}</td>
                                                    <td>{!! $branch->mobile; !!}</td>
                                                    <td class="last">                                                        
                                                        <button class="btn btn-primary" data-toggle="modal" href="#edit_branch_{!! $branch->id !!}"><i class="fa fa-edit"></i></button>
                                                        <a href="javascript:;" class="btn btn-danger jsDelete" type="tr" attr-id = "{!! $branch->id !!}" attr-href="{!! route('admin.companies.branches.delete', array($company->id, $branch->id)) !!}" data-toggle="tooltip" data-placement="top" title="Xóa" role="button"><i class="fa fa-trash-o"></i></a>
                                                        <div class="modal fade" id="edit_branch_{!! $branch->id !!}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title">Thêm mới</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {!! Form::open(array('route'=>['admin.companies.branches.edit', $company->id, $branch->id], 'id'=>'frmEditBranch_'.$k,'class'=>'form-horizontal filter-form-custom frmEditBranch')) !!}
                                                                            <input type="hidden" name="company" name="{!! $company->id !!}" />
                                                                            <div class="form-group">                       
                                                                                <label class="col-lg-2 control-label">Tên chi nhánh<span class="required">*</span></label>
                                                                                <div class="col-lg-4">
                                                                                    <input type="text" class="form-control" name="name" value="{!! $branch->name; !!}">
                                                                                </div>
                                                                                <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                                                                                <div class="col-lg-4">
                                                                                    <input type="text" class="form-control" name="address" value="{!! $branch->address; !!}">
                                                                                </div>                             
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                                                                                <div class="col-lg-4">
                                                                                    <input type="text" class="form-control" name="phone" value="{!! $branch->phone; !!}">
                                                                                </div>
                                                                                <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                                                                                <div class="col-lg-4">
                                                                                    <input type="text" class="form-control" name="mobile" value="{!! $branch->mobile; !!}">
                                                                                </div>
                                                                            </div>                   
                                                                            <div class="form-group">
                                                                                <div class="col-lg-12">
                                                                                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                                                                                </div>
                                                                            </div>
                                                                        {!! Form::close() !!}    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                
                                            @endforeach
                                            </tbody>
                                        </table>   
                                        @else
                                        Không có dữ liệu
                                        @endif
                                    </div>                                    
                                </div>
                            </td>                                             
                        </tr>
                        @endforeach
                    @else
                    <tr><td colspan="6">Không có dữ liệu</td></tr>
                    @endif
                </tbody>
            </table>            
            <!--Pagination-->
            <?php echo $companies->render(); ?>
        </div>
      </div>
  </section>
</div>
<!-- Create -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Thêm mới</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('route'=>'admin.companies.create','id'=>'frmCreate','class'=>'form-horizontal filter-form-custom')) !!}
                    <div class="form-group">                       
                        <label class="col-lg-2 control-label">Tên công ty<span class="required">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name">
                        </div>                        
                    </div>                              
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Email</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="email">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="address">
                        </div>                                               
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="mobile">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Ngày hết hạn</label>
                        <div class="col-lg-4">
                            <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="<?=date('Y-m-d');?>" class="input-append date dpYears">
                                <input type="text" size="16" class="form-control" name="date_close" value="<?=date('Y-m-d');?>">
                                <span class="input-group-btn add-on">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-calendar"></i></button>
                                </span>
                          </div>
                        </div>
                    </div>                  
                    <div class="form-group">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                        </div>
                    </div>
                {!! Form::close() !!}    
            </div>
      </div>
  </div>
</div>
<!-- End create -->

<!-- Create branch-->
<div class="modal fade" id="createBranch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Thêm mới</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('id'=>'frmCreateBranch','class'=>'form-horizontal filter-form-custom')) !!}
                    <input type="hidden" name="company" />
                    <div class="form-group">                       
                        <label class="col-lg-2 control-label">Tên chi nhánh<span class="required">*</span></label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Địa chỉ</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="address">
                        </div>                             
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Điện thoại</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <label class="col-lg-2 col-sm-2 control-label">Di động</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="mobile">
                        </div>
                    </div>                   
                    <div class="form-group">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-ban"></i> Bỏ qua</button>
                        </div>
                    </div>
                {!! Form::close() !!}    
            </div>
      </div>
  </div>
</div>
<!-- End create -->
<script type="text/javascript">
    $(document).ready(function(){        
        $('.createBranch').on('click',function() {
            var action = $(this).attr('attr-action');           
            $('#createBranch form').attr('action', action);

        });
        /*Validation form*/  
        $("#frmCreate").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Tên công ty không được để trống."                
            }
        });
         $('.frmEdit').each(function () {
            $(this).validate({
                rules: {
                    name: "required"
                },
                messages: {
                    name: "Tên công ty không được để trống."                
                }
            });
        })

        $("#frmCreateBranch").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Tên chi nhánh không được để trống."                
            }
        });

        $('.frmEditBranch').each(function () {
            $(this).validate({
                rules: {
                    name: "required"
                },
                messages: {
                    name: "Tên chi nhánh không được để trống."                
                }
            });
        })
    });
</script>
@stop