//date picker start

    if (top.location != location) {
        top.location.href = document.location.href ;
    }
    $(function(){
        window.prettyPrint && prettyPrint();
        $('.default-date-picker').datepicker({
            format: 'mm-dd-yyyy',
            autoclose: true
        });
        $('.dpYears').datepicker({
            autoclose: true
        });
        $('.dpMonths').datepicker({
            autoclose: true
        });


        var startDate = new Date(2012,1,20);
        var endDate = new Date(2012,1,25);
        $('.dp4').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() > endDate.valueOf()){
                    $('.alert').show().find('strong').text('The start date can not be greater then the end date');
                } else {
                    $('.alert').hide();
                    startDate = new Date(ev.date);
                    $('#startDate').text($('.dp4').data('date'));
                }
                $('.dp4').datepicker('hide');
            });
        $('.dp5').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() < startDate.valueOf()){
                    $('.alert').show().find('strong').text('The end date can not be less then the start date');
                } else {
                    $('.alert').hide();
                    endDate = new Date(ev.date);
                    $('.endDate').text($('.dp5').data('date'));
                }
                $('.dp5').datepicker('hide');
            });

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('.dpd1').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
        var checkout = $('.dpd2').datepicker({
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
    });

//date picker end


//datetime picker start

$(".form_datetime").datetimepicker({
    format: 'yyyy-mm-dd hh:ii',
    autoclose: true,
    todayBtn: true,
    pickerPosition: "bottom-left"

});


$(".form_datetime-component").datetimepicker({
    format: "yyyy-mm-dd hh:ii",
    autoclose: true,
    todayBtn: true,
    pickerPosition: "bottom-left"
});

$(".form_datetime-adv").datetimepicker({
    format: "yyyy-mm-dd hh:ii",
    autoclose: true,
    todayBtn: true,
    startDate: "2013-02-14 10:00",
    minuteStep: 10,
    pickerPosition: "bottom-left"

});

$(".form_datetime-meridian").datetimepicker({
    format: "yyyy-mm-dd hh:ii",
    showMeridian: true,
    autoclose: true,
    todayBtn: true,
    pickerPosition: "bottom-left"
});

//datetime picker end

//timepicker start
$('.timepicker-default').timepicker();


$('.timepicker-24').timepicker({
    autoclose: true,
    minuteStep: 1,
    showSeconds: true,
    showMeridian: false
});

//timepicker end

//colorpicker start

$('.colorpicker-default').colorpicker({
    format: 'hex'
});
$('.colorpicker-rgba').colorpicker();

//colorpicker end


//spinner start
$('#spinner1').spinner();
$('#spinner2').spinner({disabled: true});
$('#spinner3').spinner({value:0, min: 0, max: 10});
$('#spinner4').spinner({value:0, step: 5, min: 0, max: 200});
//spinner end

$('.jsShow').on('click', function(){
    var _this = $(this);
    var _key = _this.attr('attr-key');
    
    if(_this.find('i').hasClass('fa-plus-square')) {
        $('table tr').each(function(index, item){
            var _attr_key = $(item).attr('attr-key');
            $(item).find('.jsShow').html('<i class="fa fa-plus-square"></i>').removeClass('btn-danger').addClass('btn-primary');
            $('tr[attr-key="'+ _attr_key +'"]').hide();
        });

        _this.html('<i class="fa fa-minus-square"></i>').removeClass('btn-primary').addClass('btn-danger');;
        $('tr[attr-key="'+ _key +'"]').show();
    }else {
        _this.html('<i class="fa fa-plus-square"></i>').removeClass('btn-danger').addClass('btn-primary');
        $('tr[attr-key="'+ _key +'"]').hide();
    }
})

$('.jsTree').on('click', function(){
    var _this = $(this);
    var _key = _this.attr('attr-key');
    var _level = _this.attr('attr-level');
    
    if(_this.find('i').hasClass('fa-plus-square')) {
        _this.html('<i class="fa fa-minus-square"></i>').removeClass('btn-primary').addClass('btn-danger');;
        $('tr[attr-level="'+ _level +'"][attr-key="'+ _key +'"]').show();
    }else {
        _this.html('<i class="fa fa-plus-square"></i>').removeClass('btn-danger').addClass('btn-primary');
        $('tr[attr-level="'+ _level +'"][attr-key="'+ _key +'"]').hide();
    }
})

/*Delete object*/
$(".jsDelete").confirm({
    title:"Thông báo",
    text: "Bạn thực sự muốn xóa?",
    confirm: function(button) {
        var _this = button;
        var _key = _this.attr('attr-key');
        var _url = _this.attr('attr-href');
        var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var _type = _this.attr('type');
        $.ajax({
            url: _url,
            type: "POST",
            data: {_token: _CSRF_TOKEN},
            dataType: 'JSON',
            success: function(res){
                if(res.status) {                    
                    if(_type == 'tr') {
                        _this.closest('tr').remove();
                    }else{
                        $("table tr[attr-key-old='"+_key+"']").remove();
                        $("table tr[attr-key='"+_key+"']").remove();
                    }
                    type = 'success';                  
                }else {
                    type = 'Error';                   
                }
                var msg =  res.message;
                var title =  'Thông báo';
                notification(type, msg, title);             
            },
            error:function(){
            }
        });
        button.fadeOut(2000).fadeIn(2000);
    },
    cancel: function(button) {
        button.fadeOut(2000).fadeIn(2000);
    },
    confirmButton: "Có",
    cancelButton: "Không"
});

/*Notification*/
function notification(type, msg, title) {
    if(type !== undefined) {
        var i = -1;
        var toastCount = 0;
        var $toastlast;
        var shortCutFunction = type;
        var msg = msg;
        var title = title; 
        var toastIndex = toastCount++;
        var addClear = $('#addClear').prop('checked');

        toastr.options = {
            closeButton: true,
            debug: false,
            newestOnTop: false,
            progressBar: true,                
            preventDuplicates: false,
            onclick: null,
            hideDuration: 1000,
            showDuration: 300,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
            tapToDismiss: false
        };

        var $toast = toastr[shortCutFunction](msg, title); // Wire up an event handler to a button in the toast, if it exists
        $toastlast = $toast;
    }
}

function setErrors(errors,formID){
    $(formID).find('.form-group').removeClass('has-error');
    var i = 0;
    $.each(errors,function(index,value){
        if(i==0){
            $(formID).find('[name="'+index+'"]').focus();
        }
        i++;
        $(formID).find('[name="'+index+'"]').parents(".form-group").addClass('has-error');
    });
}

/*Upload image*/
$('.jsUploadImage').on('click',function(e){
    var parent = $(this).closest('.upload-file');
    parent.find('.jsImage').trigger('click');
    e.preventDefault();
    return false;
});

/*Upload image*/
$('.jsEditAvatar').on('click',function(e){
    var parent = $(this).closest('.upload-file');
    parent.find('.jsImage').trigger('click');
    e.preventDefault();
    return false;
});

/*Change image*/
$('.jsImage').on('change', function(e){
    var parent = $(this).closest('.upload-file');
    e.preventDefault();
    $('.jsLoading').show();
    var _this = $(this);
    var _url = _this.attr('attr-url');
    var _frm = $(".frmUpload");
    var formData = new FormData();
    formData.append('image', parent.find('#image')[0].files[0]);
    var _CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', _CSRF_TOKEN);
    $.ajax({
        url: _url,
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        type: 'POST',
        success: function (res) {
            $('.jsLoading').hide();
            if(res.status) { 
                parent.find('.img-active').attr('src',res.data);
                parent.find('input[name ="image_tmp"]').val(res.data);

                $('.flash').html('').append('<div class="alert alert-success fade in flash_message">'+
                                    '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>'+
                                 '<strong></strong>'+
                             '</div>');
            }else {
                $('.flash').html('').append('<div class="alert alert-danger fade in flash_message">' +
                                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                '<strong></strong>'+
                            '</div>');
            }
            $(".flash .alert strong").html(res.message);
            show_flash();
        }
    });
    return false;    
});

/*Delete image*/
$('.jsDeleteImage').on('click',function(e){
    var image_old = $('input[name ="image_old"]').val();
    $('.img-active').attr('src',image_old);
    $('input[name ="image_tmp"]').val('');
    e.preventDefault();
    return false;
});

$('#birthday').daterangepicker({
    singleDatePicker: true,
    calender_style: "picker_4"
    }, function (start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
});

function currencyFormat(n, currency) {
    if(typeof(time) == 'undefined'){
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }
    return currency + " " + n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
}
