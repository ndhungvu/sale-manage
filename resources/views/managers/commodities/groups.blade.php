@extends('layouts.manager')
@section('content')
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">Nhóm hàng hoá</header>
        <div class="panel-body">   
            <div class="adv-table">
                <div class="text-r-b-20">
                    <button class="btn btn-primary" data-toggle="modal" href="#create"><i class="fa fa-plus-square"></i> Thêm mới</button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                    <thead>
                    <tr>
                        <th class="sorting_disabled w-50"></th>
                        <th>Tên nhóm hàng</th>
                        <th class="w-300">Thuộc nhóm hàng</th>
                        <th class="w-150"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(!empty($groups) && count($groups) > 0)
                            @foreach($groups as $key => $group)
                            <tr class="gradeX old" attr-key-old="<?=$key?>" attr-level="0">
                                <td class="center">
                                    <button class="jsTree btn btn-xs btn-primary" attr-key="<?=$key?>" attr-level="0"><i class="fa fa-plus-square"></i></button>
                                </td>                             
                                <td>{!! $group->name !!}</td>
                                <td>{!! !empty($group->parent->name) ? $group->parent->name : 'Thư mục gốc '  !!}</td>
                                <td class="center">
                                    <button class="btn btn-primary jsEdit" data-toggle="modal" attr-name="{!! $group->name !!}" attr-parent-id="{!! $group->parent_id !!}" attr-id="{!! $group->id !!}" href="#edit"><i class="fa fa-edit"></i></button>
                                    <a href="javascript:void();" attr-key="<?=$key?>" attr-href="{!! route('management.products.groups.delete', $group->id) !!}" class="btn btn-danger jsDelete"><i class="fa fa-trash-o"></i></a>
                                </td>                         
                            </tr>
                            <tr class="disabled" attr-key="<?=$key?>" attr-level="0">
                                <td class="details" colspan="6" style="padding: 0 0">
                                    <table class="display table table-striped">
                                        <tbody>
                                            <?php $levels_1 = $group->childs;?>
                                            @foreach($levels_1 as $l_1 => $level_1)
                                            <tr class="gradeX old b-b" attr-key-old="<?=$key.'_'.$l_1?>" attr-level="1">
                                                <td class="center w-100">
                                                    <button class="jsTree btn btn-xs btn-primary" attr-key="<?=$key.'_'.$l_1?>" attr-level="1"><i class="fa fa-plus-square"></i></button>
                                                </td>                             
                                                <td class="border">{!! $level_1->name !!}</td>
                                                <td class="w-300 border">{!! $level_1->parent->name !!}</td>
                                                <td class="center w-150">
                                                    <button class="btn btn-primary jsEdit" data-toggle="modal" attr-name="{!! $level_1->name !!}" attr-parent-id="{!! $level_1->parent_id !!}" attr-id="{!! $level_1->id !!}" href="#edit"><i class="fa fa-edit"></i></button>
                                                    <a href="javascript:void();" attr-key="<?=$key.'_'.$l_1?>" attr-href="{!! route('management.products.groups.delete', $level_1->id) !!}" class="btn btn-danger jsDelete"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            <tr class="disabled" attr-key="<?=$key.'_'.$l_1;?>" attr-level="1">
                                                <td class="details" colspan="6" style="padding: 0 0">                                                    
                                                    <table class="display table table-striped" id="hidden-table-info">
                                                        <tbody>
                                                            <?php $levels_2 = $level_1->childs;?>
                                                            @foreach($levels_2 as $l_2 => $level_2)
                                                            <tr class="gradeX old b-b" attr-key-old="<?=$key.'_'.$l_1.'_'.$l_2?>" attr-level="2">
                                                                <td class="center w-150">
                                                                    <button class="jsTree btn btn-xs btn-primary" attr-key="<?=$key.'_'.$l_1.'_'.$l_2?>" attr-level="2"><i class="fa fa-plus-square"></i></button>
                                                                </td>                             
                                                                <td class="border">{!! $level_2->name !!}</td>
                                                                <td class="w-300 border">{!! $level_2->parent->name  !!}</td>
                                                                <td class="center w-150">
                                                                    <button class="btn btn-primary jsEdit" data-toggle="modal" attr-name="{!! $level_2->name !!}" attr-parent-id="{!! $level_2->parent_id !!}" attr-id="{!! $level_2->id !!}" href="#edit"><i class="fa fa-edit"></i></button>
                                                                    <a href="javascript:void();" attr-key="<?=$key.'_'.$l_1.'_'.$l_2?>" attr-href="{!! route('management.products.groups.delete', $level_2->id) !!}" class="btn btn-danger jsDelete"><i class="fa fa-trash-o"></i></a>
                                                                </td>                         
                                                            </tr>
                                                            <tr class="disabled" attr-key="<?=$key.'_'.$l_1.'_'.$l_2;?>" attr-level="2">
                                                                <td class="details" colspan="6" style="padding: 0 0">
                                                                    <table class="display table table-striped" id="hidden-table-info">
                                                                        <tbody>
                                                                            <?php $levels_3 = $level_2->childs;?>
                                                                            @foreach($levels_3 as $l_3 => $level_3)
                                                                            <tr class="gradeX old" attr-key-old="<?=$key.'_'.$l_1.'_'.$l_2.'_'.$l_3?>" attr-level="2">
                                                                                <td class="center w-200"></td>                           
                                                                                <td class="border">{!! $level_3->name !!}</td>
                                                                                <td class="w-300 border">{!! $level_3->parent->name !!}</td>
                                                                                <td class="center w-150">
                                                                                    <button class="btn btn-primary jsEdit" data-toggle="modal" attr-name="{!! $level_3->name !!}" attr-parent-id="{!! $level_3->parent_id !!}" attr-id="{!! $level_3->id !!}" href="#edit"><i class="fa fa-edit"></i></button>
                                                                                    <a href="javascript:void();" attr-key="<?=$key.'_'.$l_1.'_'.$l_2.'_'.$l_3?>" attr-href="{!! route('management.products.groups.delete', $level_3->id) !!}" class="btn btn-danger jsDelete"><i class="fa fa-trash-o"></i></a>
                                                                                </td>                         
                                                                            </tr>                                                                            
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>                                             
                            </tr>
                            @endforeach
                        @else
                        <tr><td colspan="4">Không có dữ liệu</td></tr>
                        @endif
                    </tbody>
                </table>            
                <!--Pagination-->
                <?php echo $groups->render(); ?>
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
                {!! Form::open(array('route'=>'management.products.groups.create','id'=>'frmCreate','class'=>'form-horizontal filter-form-custom')) !!}
                    <div class="form-group">                       
                        <label class="col-lg-2 col-sm-2 control-label">Tên nhóm hàng<span class="required">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Thuộc nhóm hàng</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="parent_id">
                                <option value="0"></option>
                                @forelse($categories as $category)
                                <option value="{!! $category['id'] !!}">{!! $category['showName'] !!}</option>
                                    @if(!empty($category['childs']))
                                        <?php $childs_1 = $category['childs'];?>
                                        @foreach($childs_1 as $child_1)
                                        <option value="{!! $child_1['id'] !!}">{!! $child_1['showName'] !!}</option>
                                            @if(!empty($child_1['childs']))
                                                <?php $childs_2 = $child_1['childs'];?>
                                                @foreach($childs_2 as $child_2)
                                                <option value="{!! $child_2['id'] !!}">{!! $child_2['showName'] !!}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @empty
                                @endforelse
                            </select>
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
<!-- Edit -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cập nhật nhóm hàng</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('id'=>'frmEdit','class'=>'form-horizontal filter-form-custom')) !!}
                    <div class="form-group">                       
                        <label class="col-lg-2 col-sm-2 control-label">Tên nhóm hàng<span class="required">*</span></label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 col-sm-2 control-label">Thuộc nhóm hàng</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="parent_id" id="parent">
                                <option value="0"></option>
                                @forelse($categories as $category)
                                <option value="{!! $category['id'] !!}">{!! $category['showName'] !!}</option>
                                    @if(!empty($category['childs']))
                                        <?php $childs_1 = $category['childs'];?>
                                        @foreach($childs_1 as $child_1)
                                        <option value="{!! $child_1['id'] !!}">{!! $child_1['showName'] !!}</option>
                                            @if(!empty($child_1['childs']))
                                                <?php $childs_2 = $child_1['childs'];?>
                                                @foreach($childs_2 as $child_2)
                                                <option value="{!! $child_2['id'] !!}">{!! $child_2['showName'] !!}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @empty
                                @endforelse
                            </select>
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
<script type="text/javascript">
    $(document).ready(function(){
        /*Validation form*/  
        $("#frmCreate").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Tên nhóm hàng không được để trống."                
            }
        });
        $("#frmEdit").validate({
            rules: {
                name: "required"
            },
            messages: {
                name: "Tên nhóm hàng không được để trống."                
            }
        });

        $('.jsEdit').on('click', function(){
            var _this = $(this);
            var _id = _this.attr('attr-id');
            var _name = _this.attr('attr-name');
            var _parent_id = _this.attr('attr-parent-id');
            var _form = $('#frmEdit');
            _form.attr('action', '/management/products/groups/edit/'+_id);
            _form.find('input[name="name"]').val(_name);
            $("#frmEdit select > option").each(function() {
                if($(this).val() == _parent_id) {
                    $(this).prop("selected", true);
                }
            });
        })
    });
</script>
@stop