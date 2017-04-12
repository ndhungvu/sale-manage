/**
* @description This file use to commodities management
* @author Phihx
*/
var purchaseOrders = [];
var stockTakeInfo = [];
var purchaseReturns = [];
var transfers = [];
var damageItems = [];

$(document).ready(function(){
  /* Start code for commodities management*/
	$(".btnSubmitFromProductCreate").click(function(){
    $("#createProductForm").find("#createProductFormType").val(0);
    ajaxValidateCreateProductForm();
  });

  $(".btnSubmitFromProductCreateMore").click(function(){
    $("#createProductForm").find("#createProductFormType").val(1);
    ajaxValidateCreateProductForm();
  });

  $(".btnSubmitFromPriceBookCreate").click(function(){
    var link = $("#createPriceBookForm").attr('action');
    var data = $("#createPriceBookForm").serialize();
    $.post(link,data,function(res){
      if(res.error){
        notification('error',res.message, 'Vui lòng kiểm tra lại thông tin!');
        setErrors(res.errors,'#createPriceBookForm');
      }else{
        $("#createPriceBookForm").submit();
      }
    });
  });

  $('#inportProductForm').submit(function(){
    var options = { 
        beforeSubmit: function(){
          $(".bs-import-product-modal-lg").find('.modal-header button').remove();
          $(".bs-import-product-modal-lg").find('.modal-footer button').attr('disabled',true);
        },
        success: function(responseText, statusText, xhr, $form){
          window.location.reload();
        },
        complete: function(xhr) {
          window.location.reload();
        }
    }; 
    $(this).ajaxSubmit(options); return false;
  });

  $(".btn-update-product").click(function(){
    var link = $(this).attr('rel');
    $.get(link,function(res){
      $(".bs-update-product-modal-lg").find('.modal-body').html(res);
      $(".bs-update-product-modal-lg").modal('show');
    });
  });

  $(".btnSubmitFromProductUpdate").click(function(){
    var link = $("#updateProductForm").attr('action');
    var data = $("#updateProductForm").serialize();
    $.post(link,data,function(res){
      if(res.error){
        notification('error',res.message, 'Vui lòng kiểm tra lại thông tin!');
        setErrors(res.errors,'#updateProductForm');
      }else{
        $("#updateProductForm").submit();
      }
    });
  });

  $(".btn-update-inactive-status-product").confirm({
    text: "Bạn có chắc chắn KHÔNG muốn kinh doanh hàng hóa này?<br/>Thông tin tồn kho và giao dịch sẽ vẫn được giữ. Bạn có thể kinh doanh trở lại hàng hóa này trong tương lai nếu muốn.?",
    title: "Xác nhận",
    confirm: function(button) {
      var link = $(button).attr('rel');
      $.post(link,{_token:token,action:'inactive'},function(res){
        if(res.error == false){
          notification('success',res.message, 'Thông báo!');
          $('tr[data-id="'+res.id+'"]').remove();
        }else{
          window.location.reload();
        }
      });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });

  $(".btn-update-active-status-product").confirm({
    text: "Bạn có chắc chắn muốn kinh doanh trở lại hàng hóa này?",
    title: "Xác nhận",
    confirm: function(button) {
      var link = $(button).attr('rel');
      $.post(link,{_token:token,action:'active'},function(res){
        if(res.error == false){
          notification('success',res.message, 'Thông báo!');
          $('tr[data-id="'+res.id+'"]').remove();
        }else{
          window.location.reload();
        }
      });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });

  $(".btn-delete-product").confirm({
    text: "Bạn có thực sự muốn xóa hàng hóa này?",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          if(res.error == false){
            notification('success',res.message, 'Thông báo!');
            $('tr[data-id="'+res.id+'"]').remove();
          }else{
            notification('error',res.message, 'Thông báo!');
          }
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });
  /* End code for commodities management*/

  /* Start code for purchase order management*/
  var productAutocomplete = new autoComplete({
      selector: '.purchase-order-create #inputProductAutoComplete',
      minChars: 1,
      cache:false,
      source: function(term, response){
          term = term.toLowerCase();
          var link = $(".purchase-order-create #inputProductAutoComplete").data('link');
          $.getJSON(link, { q: term }, function(data){ response(data); });
      },
      renderItem: function (item, search){
          return '<div class="autocomplete-suggestion" data-pid="'+item.id+'" data-pcode="'+item.code+'" data-pname="'+item.name+'" data-pon_hand="'+item.on_hand+'" data-cost="'+item.cost+'"> '+item.code+' | '+item.name+' | Tồn kho: '+item.on_hand+'</div>';
      },
      onSelect: function(e, term, item){
        $(".purchase-order-create #bodyListProducts .no-item").remove();
        var pid = item.getAttribute('data-pid');
        var pcode = item.getAttribute('data-pcode');
        var pname = item.getAttribute('data-pname');
        var pon_hand = item.getAttribute('data-pon_hand');
        var pcost = item.getAttribute('data-cost');
        if(typeof purchaseOrders[pid] == "undefined"){
          purchaseOrders[pid] = {'pname':pname, 'pid':pid, 'pcode':pcode, 'pon_hand':pon_hand, 'pcost':pcost, 'number':1, 'downprice':0};
          var html ='<tr data-id="'+pid+'">\
                        <td><a>'+pcode+'</a></td>\
                        <td>'+pname+'</td>\
                        <td><input type="text" name="Commodity['+pid+'][price]" class="form-control Commodity_price" style="width: 100px;" value="'+pcost+'" /></td>\
                        <td><input type="text" name="Commodity['+pid+'][downprice]" class="form-control Commodity_downprice" style="width: 100px;" value="0" /></td>\
                        <td><input type="number" name="Commodity['+pid+'][number]" class="form-control Commodity_number" style="width: 100px;" value="1"/></td>\
                        <td class="total">'+currencyFormat(pcost*1)+'</td>\
                        <td>\
                            <button data-id="'+pid+'" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button>\
                        </td>\
                    </tr>';
          $(".purchase-order-create #bodyListProducts").append(html);
        }else{
          purchaseOrders[pid].number+=1;
          $(".purchase-order-create").find("tr[data-id='"+pid+"']").find(".Commodity_number").val(purchaseOrders[pid].number);
          $(".purchase-order-create").find("tr[data-id='"+pid+"']").find(".total").html(currencyFormat(purchaseOrders[pid].number*purchaseOrders[pid].pcost));
        }
        
        updatePurchaseInfo();
      }
  });

  $(document).on('click',".purchase-order-create .btn-remove-item",function(){
    var pid = $(this).data('id');
    delete purchaseOrders[pid];
    $(this).parent().parent().remove();
    updatePurchaseInfo();
  });

  $(document).on('keyup',".purchase-order-create .Commodity_number, .purchase-order-create .Commodity_price, .purchase-order-create .Commodity_downprice",function(){
    var pid = $(this).parent().parent().data('id');
    var number = $(this).parent().parent().find(".Commodity_number").val();
    var price = $(this).parent().parent().find(".Commodity_price").val();
    var downprice = $(this).parent().parent().find(".Commodity_downprice").val();

    if(downprice > price){
      downprice = price;
      $(this).parent().parent().find("input[name='downprice']").val(price);
    }

    var total = (price*number) - downprice;
    purchaseOrders[pid].pcost = price;
    purchaseOrders[pid].downprice = downprice;
    purchaseOrders[pid].number = number;
    $(this).parent().parent().find(".total").html(currencyFormat(total));
    updatePurchaseInfo();
  });

  $(document).on('keyup',".purchase-order-create #sale_money",function(){
    var number = $(this).val();
    var amout_money = $(".purchase-order-create #amount_money").html();
    
    if(number > amout_money){
      $(this).val(amout_money);
    }
    updatePurchaseInfo();
  });

  $(document).on('change',".purchase-order-create .Commodity_number, .purchase-order-create .Commodity_price, .purchase-order-create .Commodity_downprice",function(){
    $(this).trigger('keyup');
  });

  $(".purchase-order-index .btn-delete-purchaseOrder").confirm({
    text: "Bạn có thực sự muốn hủy phiếu nhập hàng này không?",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          window.location.reload();
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });

  $(document).on('click','.purchase-order-index .btn-update-purchaseOrder',function(){
    var link = $(this).attr('rel');
    var note = $(this).parent().parent().find("textarea[name='purchaseOrder[note]']").val();
    var purchase_date = $(this).parent().parent().find("input[name='purchaseOrder[purchase_date]']").val();
    var user_id = $(this).parent().parent().find("select[name='purchaseOrder[user_id]']").val();
    $.post(link,{_token:token,note:note,purchase_date:purchase_date,user_id:user_id},function(res){
      window.location.reload();
    });
  });
  /* End code for purchase order management*/

  /* Start code for price book  management*/
  var pricebookAutocomplete = new autoComplete({
      selector: '.price-book #inputProductAutoComplete',
      minChars: 1,
      cache:false,
      source: function(term, response){
          term = term.toLowerCase();
          var link = $(".price-book #inputProductAutoComplete").data('link');
          $.getJSON(link, { q: term }, function(data){ response(data); });
      },
      renderItem: function (item, search){
          return '<div class="autocomplete-suggestion" data-pid="'+item.id+'" data-pcode="'+item.code+'" data-pname="'+item.name+'" data-pon_hand="'+item.on_hand+'" data-cost="'+item.cost+'" data-last_price="'+item.last_price+'" data-base_price="'+item.base_price+'"> '+item.code+' | '+item.name+' | Tồn kho: '+item.on_hand+'</div>';
      },
      onSelect: function(e, term, item){
        $(".price-book #bodyListProducts .no-item").remove();
        var pid = item.getAttribute('data-pid');
        var pcode = item.getAttribute('data-pcode');
        var pname = item.getAttribute('data-pname');
        var pon_hand = item.getAttribute('data-pon_hand');
        var pcost = item.getAttribute('data-cost');
        var last_price = item.getAttribute('data-last_price');
        var base_price = item.getAttribute('data-base_price');
        var pricebook = $(".price-book").data('pricebook');
        var link = $(".price-book").data('link') + '/' + pid;
        var linkDel = $(".price-book").data('link-del') + '/' + pid + '/' + pricebook;
        var hasProduct = $("#bodyListProducts tr").hasClass('producthasid_'+pid);
        if(hasProduct == false){
          var html ='<tr class="producthasid_'+pid+'" data-id="'+pid+'">\
                        <td>'+pcode+'</td>\
                        <td>'+pname+'</td>\
                        <td>'+pcost+'</td>\
                        <td>'+last_price+'</td>\
                        <td>\
                          <input data-new="true" data-pricebook="'+pricebook+'" rel="'+link+'" type="text" name="new_price" class="form-control new_price_change" value="'+base_price+'" />\
                        </td>\
                        <td>\
                            <button rel="'+linkDel+'" type="button" data-id="'+pid+'" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button>\
                        </td>\
                    </tr>';
          $(".price-book #bodyListProducts").append(html);
          $('.new_price_change[data-new="true"]').change();
          $('.new_price_change[data-new="true"]').removeAttr('data-new');
          $(".price-book .btn-remove-item").confirm({
            text: "Bạn có thực sự muốn xóa hàng hóa này ra khỏi bảng giá?",
            title: "Xác nhận",
            confirm: function(button) {
                var link = $(button).attr('rel');
                $.post(link,{_token:token},function(res){
                  window.location.reload();
                });
            },
            cancel: function(button) {
            },
            confirmButton: '<i class="fa fa-check"></i> Đồng ý',
            cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
            post: true,
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-default",
          });
        }else{
          notification('error','Hàng hóa này đã tồn tại trong bảng giá!', 'Thông báo');
        }
      }
  });

  $(document).on('change','.price-book .new_price_change',function(){
    var link = $(this).attr('rel');
    var pricebook = $(this).attr('data-pricebook');
    var price = $(this).val();
    $.post(link,{_token:token, new_price:price, pricebook: pricebook},function(res){
      if(res.error){
        notification('error',res.message, 'Thông báo!');
      }else{
        notification('success',res.message, 'Thông báo!');
      }
    });
  });
  
  $(".price-book .btn-remove-item").confirm({
    text: "Bạn có thực sự muốn xóa hàng hóa này ra khỏi bảng giá?",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          window.location.reload();
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });

  $(document).on('click','.price-book .btn-update-price-book',function(){
    var link = $(this).attr('rel');
    var pricebook = $(this).attr('data-id');
    $.get(link,function(res){
      $(".bs-update-pricebook-modal-lg").find('.modal-body').html(res);
      $(".bs-update-pricebook-modal-lg").modal('show');
      $(".form_datetime-adv").datetimepicker({
          format: "yyyy-mm-dd hh:ii",
          autoclose: true,
          todayBtn: true,
          startDate: "2013-02-14 10:00",
          minuteStep: 10,
          pickerPosition: "bottom-left"
      });
    });
  });

  $(document).on('click','.btnSubmitFromPriceBookUpdate',function(){
    var link = $("#updatePriceBookForm").attr('action');
    var data = $("#updatePriceBookForm").serialize();
    $.post(link,data,function(res){
      if(res.error){
        notification('error',res.message, 'Vui lòng kiểm tra lại thông tin!');
        setErrors(res.errors,'#updatePriceBookForm');
      }else{
        window.location.reload();
      }
    });
  });

  $(document).on('click','.btnDeletePriceBook',function(){
    if(!confirm('Bạn có thực sự muốn xóa bảng giá này?')){
      return false;
    }
    
    var _this = $(this);
    var link = $("#updatePriceBookForm").attr('action');
    link = link + '?delete=1';
    var data = $("#updatePriceBookForm").serialize();
    $.post(link,data,function(res){
      window.location.href = _this.attr('rel');
    });
  });
  
  /* End code for price book  management*/


  /* Start code for stock take  management*/
  var stockTakeAutocomplete = new autoComplete({
      selector: '.stock-take-create #inputProductAutoComplete',
      minChars: 1,
      cache:false,
      source: function(term, response){
          term = term.toLowerCase();
          var link = $(".stock-take-create #inputProductAutoComplete").data('link');
          $.getJSON(link, { q: term }, function(data){ response(data); });
      },
      renderItem: function (item, search){
          return '<div class="autocomplete-suggestion" data-pid="'+item.id+'" data-pcode="'+item.code+'" data-pname="'+item.name+'" data-pon_hand="'+item.on_hand+'" data-cost="'+item.cost+'"> '+item.code+' | '+item.name+' | Tồn kho: '+item.on_hand+'</div>';
      },
      onSelect: function(e, term, item){
        $(".stock-take-create #bodyListProducts .no-item").remove();
        var pid = item.getAttribute('data-pid');
        var pcode = item.getAttribute('data-pcode');
        var pname = item.getAttribute('data-pname');
        var pon_hand = item.getAttribute('data-pon_hand');
        var pcost = item.getAttribute('data-cost');
        if(typeof stockTakeInfo[pid] == "undefined"){
          stockTakeInfo[pid] = {'pname':pname, 'pid':pid, 'pcode':pcode, 'pon_hand':pon_hand, 'pcost':pcost, 'quantum':pon_hand, 'quantum_diff':0};
          var html ='<tr data-id="'+pid+'">\
                        <td><a>'+pcode+'</a></td>\
                        <td>'+pname+'</td>\
                        <td>'+ (pon_hand)+'</td>\
                        <td>\
                          <input type="number" name="Commodity['+pid+'][quantum]" class="form-control Commodity_quantum" style="width: 100px;" value="'+pon_hand+'" />\
                          <input type="hidden" name="Commodity['+pid+'][quantum_diff]" class="Commodity_quantum_diff_field" value="0" />\
                          <input type="hidden" name="Commodity['+pid+'][on_hand]" class="" value="'+pon_hand+'" />\
                        </td>\
                        <td><span class="commodity_quantum_diff">0</span></td>\
                        <td>\
                            <button type="button" data-id="'+pid+'" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button>\
                        </td>\
                    </tr>';
          $(".stock-take-create #bodyListProducts").append(html);
        }else{
          stockTakeInfo[pid].quantum = parseInt(stockTakeInfo[pid].quantum)+1;
          $(".stock-take-create").find("tr[data-id='"+pid+"']").find("input[name='Commodity["+pid+"][quantum]']").val(stockTakeInfo[pid].quantum);
        }
        
        updateStockTakeInfo();
      }
  });

  $(document).on('keyup',".stock-take-create .Commodity_quantum",function(){
    var pid = $(this).parent().parent().data('id');
    var quantum = $(this).val();
    var quantum_diff = quantum - stockTakeInfo[pid].pon_hand;

    stockTakeInfo[pid].quantum = quantum;
    stockTakeInfo[pid].quantum_diff = quantum_diff;
    $(this).parent().parent().find(".commodity_quantum_diff").html(quantum_diff);
    $(this).parent().parent().find(".Commodity_quantum_diff_field").val(quantum_diff);
    updateStockTakeInfo();
  });

  $(document).on('change',".stock-take-create .Commodity_quantum",function(){
    $(this).trigger('keyup');
  });

  $(document).on('click',".stock-take-create .btn-remove-item",function(){
    var pid = $(this).data('id');
    delete stockTakeInfo[pid];
    $(this).parent().parent().remove();
    updateStockTakeInfo();
  });

  $(".purchase-order-index .btn-delete-stocktake").confirm({
    text: "Bạn có chắc chắn muốn hủy phiếu kiểm kho này không??",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          window.location.reload();
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });
  /* End code for stock take  management*/


  /* Start code for purchase return  management*/
  var purchaseReturnAutocomplete = new autoComplete({
      selector: '.purchase-return-create #inputProductAutoComplete',
      minChars: 1,
      source: function(term, response){
          term = term.toLowerCase();
          var link = $(".purchase-return-create #inputProductAutoComplete").data('link');
          $.getJSON(link, { q: term }, function(data){ response(data); });
      },
      renderItem: function (item, search){
          return '<div class="autocomplete-suggestion" data-pid="'+item.id+'" data-pcode="'+item.code+'" data-pname="'+item.name+'" data-pon_hand="'+item.on_hand+'" data-cost="'+item.cost+'"> '+item.code+' | '+item.name+' | Tồn kho: '+item.on_hand+'</div>';
      },
      onSelect: function(e, term, item){
        $(".purchase-return-create #bodyListProducts .no-item").remove();
        var pid = item.getAttribute('data-pid');
        var pcode = item.getAttribute('data-pcode');
        var pname = item.getAttribute('data-pname');
        var pon_hand = item.getAttribute('data-pon_hand');
        var pcost = item.getAttribute('data-cost');
        if(typeof purchaseReturns[pid] == "undefined"){
          purchaseReturns[pid] = {'pname':pname, 'pid':pid, 'pcode':pcode, 'pon_hand':pon_hand, 'pcost':pcost, 'number':1, 'preturn':pcost};
          var html ='<tr data-id="'+pid+'">\
                        <td><a>'+pcode+'</a></td>\
                        <td>'+pname+'</td>\
                        <td class="">'+pcost+'<input type="hidden" name="Commodity['+pid+'][cost_price]" value="'+pcost+'" /></td>\
                        <td><input type="text" name="Commodity['+pid+'][return_price]" class="form-control Commodity_return_price" style="width: 100px;" value="'+pcost+'" /></td>\
                        <td><input type="number" name="Commodity['+pid+'][number]" class="form-control Commodity_number" style="width: 100px;" value="1"/></td>\
                        <td class="total">'+currencyFormat(pcost*1)+'</td>\
                        <td>\
                            <button data-id="'+pid+'" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button>\
                        </td>\
                    </tr>';
          $(".purchase-return-create #bodyListProducts").append(html);
        }else{
          purchaseReturns[pid].number = parseInt(purchaseReturns[pid].number)+1;
          $(".purchase-return-create").find("tr[data-id='"+pid+"']").find(".Commodity_number").val(purchaseReturns[pid].number);
          $(".purchase-return-create").find("tr[data-id='"+pid+"']").find(".total").html(currencyFormat(purchaseReturns[pid].number*purchaseReturns[pid].pcost));
        }
        
        updatePurchaseReturnsInfo();
      }
  });
  
  $(document).on('click',".purchase-return-create .btn-remove-item",function(){
    var pid = $(this).data('id');
    delete purchaseReturns[pid];
    $(this).parent().parent().remove();
    updatePurchaseReturnsInfo();
  });

  $(document).on('keyup',".purchase-return-create .Commodity_number, .purchase-return-create .Commodity_return_price, .purchase-return-create .Commodity_downprice",function(){
    var pid = $(this).parent().parent().data('id');
    var number = $(this).parent().parent().find(".Commodity_number").val();
    var return_price = $(this).parent().parent().find(".Commodity_return_price").val();

    var total = (return_price*number);
    purchaseReturns[pid].preturn = return_price;
    purchaseReturns[pid].number = number;
    $(this).parent().parent().find(".total").html(currencyFormat(total));
    updatePurchaseReturnsInfo();
  });

  $(document).on('change',".purchase-return-create .Commodity_number, .purchase-return-create .Commodity_return_price, .purchase-return-create .Commodity_downprice",function(){
    $(this).trigger('keyup');
  });

  $(document).on('click','.purchase-return-index .btn-update-purchaseReturn',function(){
    var link = $(this).attr('rel');
    var note = $(this).parent().parent().find("textarea[name='purchaseReturn[note]']").val();
    var return_date = $(this).parent().parent().find("input[name='purchaseReturn[return_date]']").val();
    var user_id = $(this).parent().parent().find("select[name='purchaseReturn[user_id]']").val();
    $.post(link,{_token:token,note:note,return_date:return_date,user_id:user_id},function(res){
      window.location.reload();
    });
  });

  $(".purchase-return-index .btn-delete-purchaseReturn").confirm({
    text: "Bạn có thực sự muốn hủy phiếu trả hàng nhập này không?",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          window.location.reload();
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });
  /* End code for purchase return  management*/

  /* Start code for transfer  management */

  var transferAutocomplete = new autoComplete({
      selector: '.transfer-create #inputProductAutoComplete',
      minChars: 1,
      source: function(term, response){
          term = term.toLowerCase();
          var link = $(".transfer-create #inputProductAutoComplete").data('link');
          $.getJSON(link, { q: term }, function(data){ response(data); });
      },
      renderItem: function (item, search){
          return '<div class="autocomplete-suggestion" data-pid="'+item.id+'" data-pcode="'+item.code+'" data-pname="'+item.name+'" data-pon_hand="'+item.on_hand+'" data-cost="'+item.cost+'"> '+item.code+' | '+item.name+' | Tồn kho: '+item.on_hand+'</div>';
      },
      onSelect: function(e, term, item){
        $(".transfer-create #bodyListProducts .no-item").remove();
        var pid = item.getAttribute('data-pid');
        var pcode = item.getAttribute('data-pcode');
        var pname = item.getAttribute('data-pname');
        var pon_hand = item.getAttribute('data-pon_hand');
        var pcost = item.getAttribute('data-cost');
        if(typeof transfers[pid] == "undefined"){
          transfers[pid] = {'pname':pname, 'pid':pid, 'pcode':pcode, 'pon_hand':pon_hand, 'pcost':pcost, 'number':1, 'ptransfer':pcost};
          var html ='<tr data-id="'+pid+'">\
                        <td><a>'+pcode+'</a></td>\
                        <td>'+pname+'</td>\
                        <td class="">'+pon_hand+'<input type="hidden" name="Commodity['+pid+'][cost_price]" value="'+pcost+'" /></td>\
                        <td><input type="number" name="Commodity['+pid+'][number]" class="form-control Commodity_number" style="width: 100px;" value="1"/></td>\
                        <td><input type="text" name="Commodity['+pid+'][transfer_price]" class="form-control Commodity_transfer_price" style="width: 100px;" value="'+pcost+'" /></td>\
                        <td>\
                            <button data-id="'+pid+'" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button>\
                        </td>\
                    </tr>';
          $(".transfer-create #bodyListProducts").append(html);
        }else{
          transfers[pid].number = parseInt(transfers[pid].number)+1;
          $(".transfer-create").find("tr[data-id='"+pid+"']").find(".Commodity_number").val(transfers[pid].number);
        }
        
        updateTransfersInfo();
      }
  });
  $(document).on('click',".transfer-create .btn-remove-item",function(){
    var pid = $(this).data('id');
    delete transfers[pid];
    $(this).parent().parent().remove();
    updateTransfersInfo();
  });

  $(document).on('keyup',".transfer-create .Commodity_number, .transfer-create .Commodity_transfer_price",function(){
    var pid = $(this).parent().parent().data('id');
    var number = $(this).parent().parent().find(".Commodity_number").val();
    var transfer_price = $(this).parent().parent().find(".Commodity_transfer_price").val();

    var total = (transfer_price*number);
    transfers[pid].ptransfer = transfer_price;
    transfers[pid].number = number;
    updateTransfersInfo();
  });

  $(document).on('change',".transfer-create .Commodity_number, .transfer-create .Commodity_transfer_price",function(){
    $(this).trigger('keyup');
  });

  $(document).on('submit', ".transfer-create #createTransferForm",function(){
    var branch = $(".transfer-create select[name='transfer[to_branch_id]']").val();
    if(branch == ''){
      notification('error','Vui lòng chọn chi nhánh muốn chuyển đến!', 'Thông báo');
      return false;
    }
  });

  $(document).on('click','.transfer-index .btn-update-transfer',function(){
    var link = $(this).attr('rel');
    var note = $(this).parent().parent().find("textarea[name='transfer[note]']").val();
    var transfer_date = $(this).parent().parent().find("input[name='transfer[transfer_date]']").val();
    var user_id = $(this).parent().parent().find("select[name='transfer[user_id]']").val();
    $.post(link,{_token:token,note:note,transfer_date:transfer_date,user_id:user_id},function(res){
      window.location.reload();
    });
  });

  $(".transfer-index .btn-delete-transfer").confirm({
    text: "Bạn có thực sự muốn hủy phiếu chuyển hàng này không?",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          window.location.reload();
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });


  /* End code for transfer  management */

  /* Start code for damage items  management*/
  var purchaseReturnAutocomplete = new autoComplete({
      selector: '.damage-items-create #inputProductAutoComplete',
      minChars: 1,
      source: function(term, response){
          term = term.toLowerCase();
          var link = $(".damage-items-create #inputProductAutoComplete").data('link');
          $.getJSON(link, { q: term }, function(data){ response(data); });
      },
      renderItem: function (item, search){
          return '<div class="autocomplete-suggestion" data-pid="'+item.id+'" data-pcode="'+item.code+'" data-pname="'+item.name+'" data-pon_hand="'+item.on_hand+'" data-cost="'+item.cost+'"> '+item.code+' | '+item.name+' | Tồn kho: '+item.on_hand+'</div>';
      },
      onSelect: function(e, term, item){
        $(".damage-items-create #bodyListProducts .no-item").remove();
        var pid = item.getAttribute('data-pid');
        var pcode = item.getAttribute('data-pcode');
        var pname = item.getAttribute('data-pname');
        var pon_hand = item.getAttribute('data-pon_hand');
        if(typeof damageItems[pid] == "undefined"){
          damageItems[pid] = {'pname':pname, 'pid':pid, 'pcode':pcode, 'pon_hand':pon_hand, 'number':1};
          var html ='<tr data-id="'+pid+'">\
                        <td><a>'+pcode+'</a></td>\
                        <td>'+pname+'</td>\
                        <td><input type="number" name="Commodity['+pid+'][number]" class="form-control Commodity_number" style="width: 100px;" value="1"/></td>\
                        <td>\
                            <button data-id="'+pid+'" class="btn btn-danger btn-xs btn-remove-item"><i class="fa fa-trash-o"></i></button>\
                        </td>\
                    </tr>';
          $(".damage-items-create #bodyListProducts").append(html);
        }else{
          damageItems[pid].number = parseInt(damageItems[pid].number)+1;
          $(".damage-items-create").find("tr[data-id='"+pid+"']").find(".Commodity_number").val(damageItems[pid].number);
          $(".damage-items-create").find("tr[data-id='"+pid+"']").find(".total").html(currencyFormat(damageItems[pid].number*damageItems[pid].pcost));
        }
        
        updateDamageItemsInfo();
      }
  });
  
  $(document).on('keyup',".damage-items-create .Commodity_number",function(){
    var pid = $(this).parent().parent().data('id');
    var number = $(this).val();

    damageItems[pid].number = number;
    updateDamageItemsInfo();
  });

  $(document).on('change',".damage-items-create .Commodity_number",function(){
    $(this).trigger('keyup');
  });

  $(document).on('click',".damage-items-create .btn-remove-item",function(){
    var pid = $(this).data('id');
    delete damageItems[pid];
    $(this).parent().parent().remove();
    updateDamageItemsInfo();
  });

  $(document).on('click','.damage-items-index .btn-update-damageItem',function(){
    var link = $(this).attr('rel');
    var note = $(this).parent().parent().find("textarea[name='damageItem[note]']").val();
    var trans_date = $(this).parent().parent().find("input[name='damageItem[trans_date]']").val();
    var user_id = $(this).parent().parent().find("select[name='damageItem[user_id]']").val();
    $.post(link,{_token:token,note:note,trans_date:trans_date,user_id:user_id},function(res){
      window.location.reload();
    });
  });

  $(".damage-items-index .btn-delete-damageItem").confirm({
    text: "Bạn có thực sự muốn hủy phiếu xuất hủy này không?",
    title: "Xác nhận",
    confirm: function(button) {
        var link = $(button).attr('rel');
        $.post(link,{_token:token},function(res){
          window.location.reload();
        });
    },
    cancel: function(button) {
    },
    confirmButton: '<i class="fa fa-check"></i> Đồng ý',
    cancelButton: '<i class="fa fa-ban"></i> Bỏ qua',
    post: true,
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
  });

  /* End code for damage items  management*/
});

function updatePurchaseInfo(){
  var amout_money = 0;
  var sale_money = $(".purchase-order-create #sale_money").val();
  var need_to_pay = 0;
  var payed_money = 0;

  purchaseOrders.forEach(function(item,index){
    var temp_total = (item.pcost*item.number) - item.downprice;
    amout_money = amout_money+temp_total;
    need_to_pay = amout_money-sale_money;
  });
  $(".purchase-order-create #amount_money").html(currencyFormat(amout_money));
  $(".purchase-order-create input[name='purchaseOrder[amount_money]']").val(amout_money);
  $(".purchase-order-create #need_to_pay").html(currencyFormat(need_to_pay));
  $(".purchase-order-create input[name='purchaseOrder[total_money]']").val(need_to_pay);
}

function updateStockTakeInfo(){
  var quantum = 0;
  var quantum_diff = 0;
  stockTakeInfo.forEach(function(item,index){
    quantum = parseInt(quantum)+parseInt(item.quantum);
    quantum_diff = parseInt(quantum_diff) + parseInt(item.quantum_diff);
  });
  $(".stock-take-create #quantum").html(quantum);
  $(".stock-take-create #quantum_diff").html(quantum_diff);
  $(".stock-take-create input[name='stockTake[quantum]']").val(quantum);
  $(".stock-take-create input[name='stockTake[quantum_diff]").val(quantum_diff);
}

function updatePurchaseReturnsInfo(){
  var amout_money = 0;
  var need_to_pay = 0;
  var payed_money = 0;

  purchaseReturns.forEach(function(item,index){
    var temp_total = (item.preturn*item.number);
    amout_money = amout_money+temp_total;
    need_to_pay = amout_money;
  });
  $(".purchase-return-create #amount_money").html(currencyFormat(amout_money));
  $(".purchase-return-create input[name='purchaseReturn[amount_money]']").val(amout_money);
  $(".purchase-return-create #need_to_pay").html(currencyFormat(need_to_pay));
  $(".purchase-return-create input[name='purchaseReturn[total_money]']").val(need_to_pay);
}

function updateTransfersInfo(){
  var total_money = 0;
  var quantum = 0;

  transfers.forEach(function(item,index){
    var temp_total = (item.ptransfer*item.number);
    quantum = quantum+ parseInt(item.number);
    total_money = total_money+temp_total;
  });
  $(".transfer-create #quantum").html(quantum);
  $(".transfer-create input[name='transfer[quantum]']").val(quantum);
  $(".transfer-create input[name='transfer[total_money]']").val(total_money);
}

function updateDamageItemsInfo(){
  var number = 0;
  console.log(damageItems);
  damageItems.forEach(function(item,index){
    number = parseInt(number)+parseInt(item.number);
  });
  $(".damage-items-create #quantum").html(number);
  $(".damage-items-create input[name='damageItem[quantum]']").val(number);
}

function ajaxValidateCreateProductForm(){
  var link = $("#createProductForm").attr('action');
  var data = $("#createProductForm").serialize();
  $.post(link,data,function(res){
    if(res.error){
      notification('error',res.message, 'Vui lòng kiểm tra lại thông tin!');
      setErrors(res.errors,'#createProductForm');
    }else{
      $("#createProductForm").submit();
    }
  });
}