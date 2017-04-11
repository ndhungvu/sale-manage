@extends('layouts.client')
@section('content')
<div class="row">
	<div>
		<div class="bill">	        			            
      	  	<div class="col-md-3">
              	<input type="text" placeholder="Tìm mặt hàng" class="form-control" id="search" autocomplete="off" />
      	    </div>
      	    <div class="col-md-2">      	    	
	                <select data-link="{{route('sale')}}" class="form-control" name="book">
                  		<option value="">---Bản giá chung---</option>
	                    @foreach ($pricebooks as $pricebook)
	                    <option @if($params->get('book') == $pricebook->id) selected @endif value="{{ $pricebook->id }}">{{ $pricebook->name }}</option>
	                    @endforeach
                  </select>
      	    </div>
  	      	<div class="col-md-7">
 		        <ul id="tab-list" class="nav nav-tabs tab-bills" role="tablist">
 		        	@foreach($bills as $key => $bill)
                    <li class="{!! $key == 0 ? 'active' :'' !!}"><a href="#tab_{!! $key + 1 !!}" role="tab" data-toggle="tab">Hóa đơn {!! $key + 1 !!} <button class="close" attr-bill-id="{!! $bill->id !!}" type="button" title="Xóa">&nbsp;×</button></a></li>
                    @endforeach
                    <a id="jsAddTab" class="btn btn-primary" style="margin-top: 3px;"><i class="fa fa-plus-square"></i></a>                
                </ul>
 	        </div>
	    </div>
	</div>

 	<div class="col-md-12">
		<section class="panel">	       
           	<div class="panel-body">        	    
			    <div class="tab-content" id="tab-content" style="min-height:300px; background: #FFF;">
			    	@foreach($bills as $key => $bill)
		            <div class="jsTab tab-pane fade in {!! $key == 0 ? 'active' :'' !!}" id="tab_{!! $key + 1 !!}">
		            	{!! Form::open(array('id'=>'frmCreate','method'=>'POST', 'class'=>'form-horizontal filter-form-custom')) !!}
		            		<input type="hidden" id="bill_id" name="bill_id" value="{!! $bill->id !!}" />
			            	<div class="col-md-8">
				                <table class="table table-striped table-advance table-hover jsProducts">                              
				                  	<tbody>
				                  		@if(!empty($bill->bill_sale_commodities))
				                  			<?php $bill_sale_commodities = $bill->bill_sale_commodities;
				                  				$total = 0;
				                  			?>
				                  			@foreach($bill_sale_commodities as $bill_sale_commodity)
				                  			<?php 
				                  				$product = $bill_sale_commodity->commodity;
				                  				$base_price =  $product->price_quote;
				                  				$total = $total + $base_price*$bill_sale_commodity->number;
				                  			?>
				                  			<tr attr-product-id="{!! $product->id !!}">
				                                <td class="w-20"><button class="btn btn-danger btn-xs jsRemove"><i class="fa fa-trash-o "></i></button></td>
				                                <td class="w-50">{!! $product->code !!}</td>
				                                <td><strong>{!! $product->name !!}</strong></td>
				                                <td class="w-150">
				                                    <input type="text" name="price_base[]" placeholder="0" class="form-control right jsPriceSellBase" disabled id="price_base" value="{!! number_format($base_price) !!}">
				                                </td>
				                                <td class="w-200">
				                                    <a id="jsDownNumber" class="btn btn-default f-left jsDownNumber"><i class="fa fa-angle-down"></i></a>
				                                    <input type="number" name="number[]" placeholder="0" class="jsNumber form-control right w-80 f-left" id="number" value="{!! $bill_sale_commodity->number !!}" min="1">
				                                    <a id="jsUpNumber" class="btn btn-default jsUpNumber"><i class="fa fa-angle-up"></i></a>
				                                </td>                                  
				                                <td class="w-100" align="right"><strong><span id="price" class="jsPriceSell">{!! number_format($base_price*$bill_sale_commodity->number) !!}</span></strong></td>
				                            </tr>
				                            <input type="hidden" name="product_id[]" id="product_id" value="{!! $product->id !!}"/>
				                  			@endforeach
				                  		@endif
				                  	</tbody>
				                </table>
				            </div>
				            <div class="col-md-4 col-right">
						  		<section class="panel pay">
						  			<div class="panel-body">							  		
									  	<ul class="nav nav-tabs" role="tablist">
									    	<li role="presentation" class="active"><a href="#information" aria-controls="information" role="tab" data-toggle="tab">Thông tin</a></li>
									    	<li role="presentation"><a href="#note" aria-controls="note" role="tab" data-toggle="tab">Chú thích</a></li>
									  	</ul>
								 		<div class="tab-content row m-10">
								    		<div role="tabpanel" class="tab-pane active" id="information">
								    			<div class="form-group">
								    				<div class="col-md-10">
								    					<input type="text" placeholder="Tìm khách hàng" class="form-control jsCustomers" attr-id="{!! $key + 1 !!}" id="customer_{!! $key + 1 !!}">   				
								    					<input type="hidden" name="customer_id" value=""/>
								    				</div>								    				
								    				<div class="col-md-2">
								    					<a id="jsAddCustomer" class="btn btn-primary"><i class="fa fa-plus-square"></i></a>
								    				</div>
								    				<div class="col-md-12">
								    					<p class="m-10 jsCustomerName">Khách lẻ </p>
								    				</div>
								    			</div>    					  		
								    		</div>								    		
											<div role="tabpanel" class="tab-pane" id="note">
												<textarea class="form-control" rows="3" placeholder="Ghi chú..." name="note">{!! $bill->note !!}</textarea>
											</div>
								  		</div>
								  		<ul class="nav nav-tabs" role="tablist">
									    	<li role="presentation" class="active"><a href="#Hóa đơn" aria-controls="c" role="tab" data-toggle="tab">Hóa đơn</a></li>			    	
									  	</ul>			  
								 		<div class="tab-content col-md-12 m-10">
								    		<div role="tabpanel" class="tab-pane active" id="Hóa đơn">
								    			<span class="jsFixPrice jsDisabled">{!! number_format($total) !!}</span>
								    			<div class="form-group">
								    				<label class="col-sm-6 control-label"><strong>Tổng tiền hàng</strong></label>
								    				<div class="col-sm-6" align="right"><strong><span class="jsTotalPrice">{!! number_format($total) !!}</span></strong></div>
								    			</div>
								    			<div class="form-group">
								    				<label class="col-sm-6 control-label"><strong>Giảm giá</strong></label>
								    				<div class="col-md-6">
								    					<input type="text" name="discount" placeholder="0" class="form-control right jsDiscount" id="discount" value="{!! number_format($bill->discount) !!}">   				
								    				</div>
								    			</div>
								    			<div class="form-group">
								    				<label class="col-sm-6 control-label"><strong>Khách cần trả</strong></label>
								    				<div class="col-sm-6 red" align="right"><strong><span class="jsTotal">{!! number_format($total) !!}</span></strong></div>
								    				<input type="hidden" name="total" value="{!! number_format($total) !!}" />
								    			</div>
								    			<div class="form-group">
								    				<label class="col-sm-6 control-label"><strong>Khách thanh toán</strong></label>
								    				<div class="col-md-6">
								    					<input type="text" name="pay" placeholder="0" class="form-control right jsPay" id="pay" value="{!! number_format($bill->pay) !!}">   				
								    				</div>
								    			</div>
								    		</div>		    		
								  		</div>
								  		<div class="form-group right">
						    				<a id="print" class="btn btn-warning"><i class="fa fa-print"></i>&nbsp In</a>
						    				<button type="button" class="btn btn-primary jsSubmit"><i class="fa fa-usd"></i>&nbsp Thanh toán</button>
						    			</div>
								  	</div>
						  		</section>
						  	</div>
					  	{!! Form::close() !!}
		            </div>
		            @endforeach
	            </div>
     		</div>
      	</section>      	   	
  	</div>

  	<div class="col-md-12">
  		<section class="panel">
	        <header class="panel-heading">
	            Sản phẩm
	        </header>
	        <div class="panel-body">
	            <div class="row product-list">
	            	@if(!empty($products))
                    @foreach($products as $key => $product)
                    	@if(!empty($product->commodity))
    		          	<div class="col-md-2 border">
    		              	<section class="panel jsProduct" attr-product-id="{!! $product->commodity->id !!}">
    		                  	<div class="pro-img-box p-t-5">
    		                  		<img src="{{ $product->commodity->getImage() }}" style="object-fit: cover; height: 120px;">	                      	
    		                      	<a href="javascript:;" class="adtocart">{!! $product->on_hand !!}</a>
    		                    </div>

    		                    <div class="text-center p-t-5">
    		                        <h4><a href="javascript:;" class="pro-title description-1">{!! $product->commodity->name !!}</a></h4>
    		                        <p class="price">{!! !is_null($product->base_book_price) ? number_format($product->base_book_price) : number_format($product->commodity->base_price) !!} VND</p>
    		                    </div>
    		                </section>
    		          	</div>
    		          	@endif
                    @endforeach
                    <div class="col-md-12 right">
                    <?php echo $products->render(); ?>
                    </div>
                    @else
                    <p>Không có sản phẩm.</p>
                    @endif
      	        </div>
	        </div>
	    </section>
  	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		
    	var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var tabID = $("#tab-list li").length;
        if(tabID >= 5) {
        	$('#jsAddTab').hide();
        }
        $('#jsAddTab').click(function (e) {
        	e.preventDefault();
			tabID = parseInt(tabID) + 1;
            createBill(tabID);
           
            if(tabID >= 5) {
            	$(this).hide();
            }
        });
        $("#tab-list .close").confirm({
		    title:"Thông báo",
		    text: "Bạn thực sự muốn xóa?",
		    confirm: function(button) {
		        var _this = button;
		       	var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		       	var _bill_id = _this.attr('attr-bill-id');
			   	var _url = 'sale/bill/delete/'+ _bill_id;
		        $.ajax({
			        url: _url,
			        type: 'GET',
			        dataType: 'JSON',
			        data: {'_token': _CSRF_TOKEN},
			        success: function (res) {
			            if(res.status) {
			            	window.location.href = window.location;
			            }
			        }
					})
		        button.fadeOut(2000).fadeIn(2000);
		    },
		    cancel: function(button) {
		        button.fadeOut(2000).fadeIn(2000);
		    },
		    confirmButton: "Có",
		    cancelButton: "Không"
		});

        $('.jsProduct').on('click', function(e){
        	var _id = $(this).attr('attr-product-id');        	
        	up_product(_id);
        })
		var arr = [];
		$.ajax({
	        url: '/sale/products',
	        type: 'GET',
	        dataType: 'JSON',
	        data: {'_token': _CSRF_TOKEN},		
	        success: function (res) {
	        	var datas = res.data;
                $.each(datas, function (key, val) {
                    arr.push(val);
                });
                selectAuto();
            }
        });

		/*Search auto*/		
        var contacts = arr;
		var $text = $('#search');
		var typeahead = $('#search').typeahead({source: contacts}).data('typeahead');
		typeahead.select = function () {
		    var _id = this.$menu.find('.active').attr('data-value');
		    var text = this.$menu.find('.active').text();
		    this.$element.val(this.updater(text))
		        .trigger('selected');

		    up_product(_id);
		    return this.hide();
		};

		/*Search customer auto*/	
		search_customers_auto();		
		
		$(".jsTab").each(function() {
			var _this = $(this);
			if(_this.attr('id') != 'tab_1')
				_this.removeClass('in');
			var items = _this.find('table.jsProducts tr');
			$(items).each(function(){
		        var item = $(this);
		        upNumber(item);
		        downNumber(item);
		        removeItem(item);
		        priceChange(item)
		    });
		})
		

	    $('.jsSubmit').on('click', function(){
	    	var _this = $(this);
	    	if(_this.closest('form').find("table.jsProducts > tbody > tr").length > 0) {
	    		_this.closest('form').submit();
	    	}else {
	    		notification('error', 'Phiếu hàng đang trống.', 'Thông báo');
	    	}
	    })

	    $('select[name="book"]').change(function(){
	    	var link = $(this).data('link');
	    	var book  = $(this).val();
	    	window.location.href = link + '?book=' + book;
	    });

	    change_number($('.jsNumber'));
	    change_discount($('.jsDiscount'));
	    change_pay($('.jsPay'));
	    
    });

	function change_pay(item) {
		item.on('change', function() {
	    	var _this = $(this);
	    	var _pay = _this.val();
	    	var _total_price = parseInt($(this).closest('#frmCreate').find('.active .jsFixPrice').text().replace(/\,/g, ''));
	    	if(!$.isNumeric(_pay) || parseInt(_pay) < 0 || parseInt(_pay) > _total_price) {
	    		_pay = 0;
	    		_this.val(_pay);
	    	}
			_this.val(humanizeNumber(_pay));
	    })
	}

	function change_discount(item) {
		item.on('change', function() {
	    	var _this = $(this);
	    	var _discount = _this.val();
	    	var _total_price = parseInt($(this).closest('#frmCreate').find('.active .jsFixPrice').text().replace(/\,/g, ''));
	    	if(!$.isNumeric(_discount) || parseInt(_discount) < 0 || parseInt(_discount) > _total_price) {
	    		_discount = 0;
	    		_this.val(_discount);
	    	}
	    	_total_price = humanizeNumber(_total_price - _discount);
			$("#tab-content").find('.in .jsTotal').text(_total_price);
			$("#tab-content").find('.in input[name="total"]').val(_total_price);
			_this.val(humanizeNumber(_discount));
	    })
	}

	function change_number(item) {
		item.on('change', function() {
        	var _this = $(this);
        	var _attr_product_id = _this.closest('tr').attr('attr-product-id');
        	var _number_sale = _this.val();
        	var _number_product = $('.jsProduct[attr-product-id="'+_attr_product_id+'"]').find('.adtocart').text();
        	var _price_sell_base = parseInt(_this.closest('tr').find('.jsPriceSellBase').val().replace(/\,/g, ''));
        	if(parseInt(_number_sale) <= parseInt(_number_product)) {
        		_total = _number_sale * _price_sell_base;
        		_total_price = humanizeNumber(_total);
        		$("#tab-content").find('.in .jsTotalPrice').text(_total_price);
        		$("#tab-content").find('.in .jsFixPrice').text(_total_price);
        		var _discount = parseInt($('#tab-content .active #frmCreate').find('.jsDiscount').val().replace(/\,/g, ''));

				$("#tab-content").find('.in .jsTotal').text(humanizeNumber(_total - _discount));
				$("#tab-content").find('.in input[name="total"]').val(_total_price);
        	}else {
        		notification('error', 'Sản phẩm hết hàng trong hệ thống.', 'Thông báo');
        	}
        })
	}
	function search_customers_auto() {
		var customers = [];
		var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
	        url: '/sale/customers',
	        type: 'GET',
	        dataType: 'JSON',
	        data: {'_token': _CSRF_TOKEN},		
	        success: function (res) {
	        	var datas = res.data;
                $.each(datas, function (key, val) {
                    customers.push(val);
                });
                selectAuto();
            }
        });

		$('.jsCustomers').each(function(i, obj) {
		    var _attr_id = $(this).attr('attr-id');
		    var $text = $('#customer_'+_attr_id);
			var typeahead = $text.typeahead({source: customers}).data('typeahead');
			typeahead.select = function () {
			    var _id = this.$menu.find('.active').attr('data-value');
			    var text = this.$menu.find('.active').text();
			    this.$element.val(this.updater(text))
			        .trigger('selected');

			    $text.val('');
			    $('#tab-content .active #frmCreate').find('input[name="customer_id"]').val(_id);
			    $('#tab-content .active #frmCreate').find('.jsCustomerName').text(text);
			    
			    return this.hide();
			};
		});
	}
	function createBill(tabID) {
		var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    	var _url = '/sale/bill/create';
    	$.ajax({
	        url: _url,
	        type: 'GET',
	        dataType: 'JSON',
	        data: {'_token': _CSRF_TOKEN},
	        success: function (res) {
	            if(res.status) {
	            	
	            	$('#tab-list').append($('<li class="active"><a href="#tab_' + tabID + '" role="tab" data-toggle="tab">Hóa đơn ' + tabID + '<button class="close" attr-bill-id="'+res.data.id+'"  type="button" title="Remove this page">&nbsp×</button></a></li>'));
    				var _html = '<div class="jsTab tab-pane fade" id="tab_' + tabID + '">' +
        				'<form method="POST" action="/sale" id="frmCreate" class="form-horizontal">'+
        					'<input name="_token" type="hidden" value="{!! csrf_token(); !!}">'+
        					'<input type="hidden" id="bill_id" name="bill_id" value="'+res.data.id+'" />' +
            				'<div class="col-md-8">' +
            					'<table class="table table-striped table-advance table-hover jsProducts"><tbody></tbody></table>' +
            				'</div>' +
            				'<div class="col-md-4 col-right">' +
						  		'<section class="panel pay">' +
						  			'<div class="panel-body">' +
									  	'<ul class="nav nav-tabs" role="tablist">' +
									    	'<li role="presentation" class="active"><a href="#information_' + tabID + '" aria-controls="information" role="tab" data-toggle="tab">Thông tin</a></li>' +
									    	'<li role="presentation"><a href="#note_' + tabID + '" aria-controls="note" role="tab" data-toggle="tab">Chú thích</a></li>' +
									  	'</ul>' +
								 		'<div class="tab-content row m-10">' +
								    		'<div role="tabpanel" class="tab-pane active" id="information_' + tabID + '">' +
								    			'<div class="form-group">' +
								    				'<div class="col-md-10">' +
								    					'<input type="text" placeholder="Tìm khách hàng" class="form-control jsCustomers" attr-id="' + tabID + '" id="customer_' + tabID + '">  ' + 				
								    					'<input type="hidden" name="customer_id" value=""/>'+
								    				'</div>' +
								    				'<div class="col-md-2">' +
								    					'<a id="jsAddCustomer" class="btn btn-primary"><i class="fa fa-plus-square"></i></a>' +
								    				'</div>' +
								    				'<div class="col-md-12">' +
								    					'<p class="m-10 jsCustomerName">Khách lẻ </p>' +
								    				'</div>' +
								    			'</div>' +  					  		
								    		'</div>' +
											'<div role="tabpanel" class="tab-pane" id="note_' + tabID + '">' +
												'<textarea class="form-control" rows="3" placeholder="Ghi chú..."></textarea>' +
											'</div>' +
								  		'</div>' +
								  		'<ul class="nav nav-tabs" role="tablist">' +
									    	'<li role="presentation" class="active"><a href="#Hóa đơn" aria-controls="c" role="tab" data-toggle="tab">Hóa đơn</a></li>' +
									  	'</ul>' +	  
								 		'<div class="tab-content col-md-12 m-10">' +
								    		'<div role="tabpanel" class="tab-pane active" id="Hóa đơn">' +
								    			'<span class="jsFixPrice jsDisabled">0</span>'+
								    			'<div class="form-group">' +
								    				'<label class="col-sm-6 control-label"><strong>Tổng tiền hàng</strong></label>' +
								    				'<div class="col-sm-6" align="right"><span class="jsTotalPrice">0</span></div>' +
								    			'</div>' +
								    			'<div class="form-group">' +
								    				'<label class="col-sm-6 control-label"><strong>Giảm giá</strong></label>' +
								    				'<div class="col-md-6">' +
								    				'<input type="text" name="discount" placeholder="0" class="form-control right jsDiscount" id="discount" value="0">' +
								    				'</div>' +
								    			'</div>' +
								    			'<div class="form-group">' +
								    				'<label class="col-sm-6 control-label"><strong>Khách cần trả</strong></label>' +
								    				'<div class="col-sm-6 red" align="right"><strong><span class="jsTotal">0</span></strong></div>' +
								    			'</div>' +
								    			'<div class="form-group">' +
								    				'<label class="col-sm-6 control-label"><strong>Khách thanh toán</strong></label>' +
								    				'<div class="col-md-6">' +
								    					'<input type="text" name="pay" placeholder="0" class="form-control right jsPay" id="pay" value="0">' +
								    				'</div>' +
								    			'</div>' +
								    			'<input type="hidden" name="total" value="0" />'+
								    		'</div>' +		    		
								  		'</div>' +
								  		'<div class="form-group right">' +
						    				'<a id="print" class="btn btn-warning"><i class="fa fa-print"></i>&nbsp In</a>' +
						    				'<button type="button" class="left-3 btn btn-primary jsSubmit"><i class="fa fa-usd"></i>&nbsp Thanh toán</button>' +
						    			'</div>' +									  		
								  	'</div>' +
						  		'</section>' +
					  		'</div>' +
				  		'</form>' +
        			'</div>';
        			$('#tab-content').append(_html);

				    var $text = $('#customer_' + tabID);
					var typeahead = $text.typeahead({source: this.customers}).data('typeahead');
					typeahead.select = function () {
					    var _id = this.$menu.find('.active').attr('data-value');
					    var text = this.$menu.find('.active').text();
					    this.$element.val(this.updater(text))
					        .trigger('selected');

					    up_product(_id);
					    return this.hide();
					};
					$("#tab-list .close").confirm({
					    title:"Thông báo",
					    text: "Bạn thực sự muốn xóa?",
					    confirm: function(button) {
					        var _this = button;
					       	var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
					       	var _bill_id = _this.attr('attr-bill-id');
						   	var _url = 'sale/bill/delete/'+ _bill_id;
					        $.ajax({
						        url: _url,
						        type: 'GET',
						        dataType: 'JSON',
						        data: {'_token': _CSRF_TOKEN},
						        success: function (res) {
						            if(res.status) {
						            	window.location.href = window.location;
						            }
						        }
								})
					        button.fadeOut(2000).fadeIn(2000);
					    },
					    cancel: function(button) {
					        button.fadeOut(2000).fadeIn(2000);
					    },
					    confirmButton: "Có",
					    cancelButton: "Không"
					});

					$('.jsSubmit').on('click', function(){
				    	var _this = $(this);
				    	if(_this.closest('form').find("table.jsProducts > tbody > tr").length > 0) {
				    		_this.closest('form').submit();
				    	}else {
				    		notification('error', 'Phiếu hàng đang trống.', 'Thông báo');
				    	}
				    })
					$('#tab-list li').each(function(i, val) { 
						$(this).removeClass('active');
					});
				    $('#tab-list li:last a').trigger('click');

				    search_customers_auto();
				    change_number($('.jsNumber'));
	    			change_discount($('.jsDiscount'));
	    			change_pay($('.jsPay'));
	            }
	        }
	    })
	}

	function upNumber(item) {
        item.find('.jsUpNumber').on('click', function(e){
        	e.preventDefault();
			var _id = $(this).closest('tr').attr('attr-product-id');
			up_product(_id);
		})
    }

    function downNumber(item) {
        item.find('.jsDownNumber').on('click', function(e){
        	e.preventDefault();
        	var _id = $(this).closest('tr').attr('attr-product-id');
        	down_product(_id);
			var _number = parseInt($(this).closest('tr').find('.jsNumber').val());
			if(parseInt(_number) > 1){
				$(this).closest('tr').find('.jsNumber').val(_number - 1);
				var _price_base = parseInt($(this).closest('tr').find('.jsPriceSellBase').val().replace(/\,/g, ''));
				var _price_sell = parseInt($(this).closest('tr').find('.jsPriceSell').text().replace(/\,/g, ''));
				$(this).closest('tr').find('.jsPriceSell').text(humanizeNumber(_price_sell - _price_base));

				/*Total price*/
				var _total_price = parseInt($(this).closest('#frmCreate').find('.active .jsTotalPrice').text().replace(/\,/g, ''));
				$(this).closest('.in').find('.jsTotalPrice').text(humanizeNumber(_total_price - _price_base));
				$(this).closest('.in').find('.jsFixPrice').text(humanizeNumber(_total_price - _price_base));
				var _discount = parseInt($('#tab-content .active #frmCreate').find('.jsDiscount').val().replace(/\,/g, ''));

				$(this).closest('.in').find('.jsTotal').text(humanizeNumber(_total_price - _price_base - _discount));
				$(this).closest('.in').find('input[name="total"]').val(humanizeNumber(_total_price - _price_base));
			}
		})
    }

    function removeItem(item) {
        item.find('.jsRemove').on('click', function(e){
        	e.preventDefault();
        	var _this = $(this);
        	var _id = _this.closest('tr').attr('attr-product-id');
        	var _bill_id = _this.closest('.jsTab').find('#bill_id').val();
        	var _number = _this.closest('tr').find('.jsNumber').val()
        	remove_product(_this,_bill_id, _id, _number);
		})
    }

    function selectAuto() {
    	$('ul.typeahead li').on('click', function(e){
    		e.preventDefault();
    		var _id = $(this).attr('data-value');
    		up_product(_id);
    	})
    }

    function priceChange(item) {
    	item.find('.jsPriceSellBase').on('change', function(e){
        	e.preventDefault();
        	var _price_base = parseInt($(this).val().replace(/\,/g, ''));
			var _number = parseInt($(this).closest('tr').find('.jsNumber').val());
			$(this).closest('tr').find('.jsPriceSell').text(humanizeNumber(_price_base * _number ));
		})
    }

    function up_product(_id) {
    	var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    	var _bill_id = $('#tab-content .active #bill_id').val();
    	var _url = '/sale/product/' + _bill_id +'/'+ _id;
    	$.ajax({
	        url: _url,
	        type: 'GET',
	        dataType: 'JSON',
	        data: {
	        	'_token': _CSRF_TOKEN,
	        	'book' : {!! !empty($_GET['book']) ? $_GET['book'] : '0'!!}
	        },
	        success: function (res) {
	        	if(res.status) {
	        		if(res.data !== undefined) {
	        			var product = res.data.commodity;
			            var _id = product.id;
			            var _ok = false;
			            $("#tab-content").find('.in table.jsProducts tr').each(function(){
			            	_product_id = $(this).attr('attr-product-id');
			            	if(_product_id == _id) {
			            		_ok = true;
			            	}
			            })
			            if (!_ok) {
			            	product.base_price = parseInt(product.price_quote);
				            _tr = '<tr attr-product-id="'+_id+'">' +
		                                '<td class="w-20"><button class="btn btn-danger btn-xs jsRemove"><i class="fa fa-trash-o "></i></button></td>' +
		                                '<td class="w-50">'+product.code+'</td>' +
		                                '<td><strong>'+product.name+'</strong></td>' +
		                                '<td class="w-150">' +
		                                    '<input type="text" name="price_base[]" placeholder="0" class="form-control right jsPriceSellBase" disabled id="price_base" value="'+humanizeNumber(product.base_price)+'">' +
		                                '</td>' +
		                                '<td class="w-200">' +
		                                    '<a id="jsDownNumber" class="btn btn-default f-left jsDownNumber"><i class="fa fa-angle-down"></i></a>' +
		                                    '<input type="number" name="number[]" placeholder="0" class="jsNumber form-control right w-80 f-left" id="number" value="1" min="1">' +
		                                    '<a id="jsUpNumber" class="btn btn-default jsUpNumber"><i class="fa fa-angle-up"></i></a>' +
		                                '</td>' +                                  
		                                '<td class="w-100" align="right"><strong><span id="price" class="jsPriceSell">'+humanizeNumber(product.base_price)+'</span></strong></td>' +
		                            '</tr>' +
		                            '<input type="hidden" name="product_id[]" id="product_id" value="' +_id + '"/>';
				            $("#tab-content").find('.in table.jsProducts').append(_tr);

				            var _price_base = parseInt(product.base_price);
				            var _total_price = parseInt($("#tab-content").find('.in .jsTotalPrice').text().replace(/\,/g, ''));
							$("#tab-content").find('.in .jsTotalPrice').text(humanizeNumber(_total_price + _price_base));
							$("#tab-content").find('.in .jsFixPrice').text(humanizeNumber(_total_price + _price_base));
							var _total = parseInt($("#tab-content").find('.in .jsTotal').text().replace(/\,/g, ''));

							$("#tab-content").find('.in .jsTotal').text(humanizeNumber(_total + _price_base));
							$("#tab-content").find('.in input[name="total"]').val(humanizeNumber(_total + _price_base));

							var item = $("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]');
				            upNumber(item);
				            downNumber(item);
				            removeItem(item);
				            priceChange(item)
				        }else {
				        	var _number = $("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]').find('.jsNumber').val();			        	
				        	if(parseInt(_number) < parseInt(product.on_hand)) {
				        		$('table.jsProducts tr[attr-product-id="'+_id+'"]').find('.jsNumber').val(parseInt(_number) + 1);

								var _price_base = parseInt($("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]').find('.jsPriceSellBase').val().replace(/\,/g, ''));
								var _price_sell = parseInt($("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]').find('.jsPriceSell').text().replace(/\,/g, ''));
								$("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]').find('.jsPriceSell').text(humanizeNumber(_price_sell + _price_base));

								var _total_price = parseInt($('#tab-content .active #frmCreate').find('.jsTotalPrice').text().replace(/\,/g, ''));
								var _discount = parseInt($('#tab-content .active #frmCreate').find('.jsDiscount').val().replace(/\,/g, ''));

								$("#tab-content").find('.in .jsTotalPrice').text(humanizeNumber(_total_price + _price_base));
								$("#tab-content").find('.in .jsFixPrice').text(humanizeNumber(_total_price + _price_base));
								$("#tab-content").find('.in .jsTotal').text(humanizeNumber(_total_price + _price_base - _discount));
								$("#tab-content").find('.in input[name="total"]').val(humanizeNumber(_total_price + _price_base));						
				        	}else {
				        		notification('error', 'Sản phẩm hết hàng trong hệ thống.', 'Thông báo');
				        	}							
				        }
	        		}else {
	        			notification('error', res.message, 'Thông báo');
	        		}	        		
	        	}else {
	        		notification('error', res.message, 'Thông báo');
	        	}
	            change_number($('.jsNumber'));
		        return false;
	        }
	    })
	}

	function down_product(_id) {
    	var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    	var _bill_id = $('#tab-content .active #bill_id').val();
    	var _url = '/sale/product/down/' + _bill_id +'/'+ _id;
    	$.ajax({
	        url: _url,
	        type: 'GET',
	        dataType: 'JSON',
	        data: {'_token': _CSRF_TOKEN},
	        success: function (res) {
	            var product = res.data;
	            var _id = product.id;
	            var _ok = false;
	            $("#tab-content").find('.in table.jsProducts tr').each(function(){
	            	_product_id = $(this).attr('attr-product-id');
	            	if(_product_id == _id) {
	            		_ok = true;
	            	}
	            })
	            if (!_ok) {
		            var _price_base = parseInt(product.base_price.replace(/\,/g, ''));
		            var _total_price = parseInt($("#tab-content").find('.in .jsTotalPrice').text().replace(/\,/g, ''));
					$("#tab-content").find('.in .jsTotalPrice').text(humanizeNumber(_total_price - _price_base));
					$("#tab-content").find('.in .jsFixPrice').text(humanizeNumber(_total_price - _price_base));
					var _total = parseInt($("#tab-content").find('.in .jsTotal').text().replace(/\,/g, ''));
					$("#tab-content").find('.in .jsTotal').text(humanizeNumber(_total - _price_base));
					$("#tab-content").find('.in input[name="total"]').val(humanizeNumber(_total - _price_base));

					var item = $("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]');
		            upNumber(item);
		            downNumber(item);
		            removeItem(item);
		            priceChange(item)
		        }
		        return false;
	        }
	    })
	}

	function remove_product(_this, _bill_id, _id, _number) {
    	var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    	var _url = '/sale/product/remove/' + _bill_id +'/'+ _id + '/' +_number;
    	$.ajax({
	        url: _url,
	        type: 'GET',
	        dataType: 'JSON',
	        data: {'_token': _CSRF_TOKEN},
	        success: function (res) {
	            if(res.status) {
	            	$("#tab-content").find('.in table.jsProducts #product_id[value="'+_id+'"]').remove();
	            	$("#tab-content").find('.in table.jsProducts tr[attr-product-id="'+_id+'"]').remove();
	            	_price_base = res.price;
	            	/*Total price*/
					var _total_price = parseInt($('#tab-content .active #frmCreate').find('.jsTotalPrice').text().replace(/\,/g, ''));
					$('#tab-content .active #frmCreate').find('.jsTotalPrice').text(humanizeNumber(_total_price - _price_base));
					$('#tab-content .active #frmCreate').find('.jsFixPrice').text(humanizeNumber(_total_price - _price_base));
					$('#tab-content .active #frmCreate').find('input[name="total"]').val(humanizeNumber(_total_price - _price_base));
					var _discount = parseInt($('#tab-content .active #frmCreate').find('.jsDiscount').val().replace(/\,/g, ''));

					var _total = _total_price - _price_base -_discount;
					if(_total <= 0) {
						_total = 0;
						$('#tab-content .active #frmCreate').find('.jsDiscount').val(0);
					}
					$('#tab-content .active #frmCreate').find('.jsTotal').text(humanizeNumber(_total));
					
	            }
	        }
	    })
	}

	function humanizeNumber(value) {
	  	return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}
</script>
@stop