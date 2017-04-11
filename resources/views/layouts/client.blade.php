<!DOCTYPE html>
<html lang="en">  
    <!-- Mirrored from thevectorlab.net/flatlab/product_list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Jun 2016 01:35:22 GMT -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="/assets/admin/img/favicon.html">
        <meta name="csrf-token" content="{!! csrf_token() !!}">

        <title>Bán hàng online</title>

        <!-- Bootstrap core CSS -->
        {!! Html::style('/assets/admin/css/bootstrap.min.css') !!}
        {!! Html::style('/assets/admin/css/bootstrap-reset.css') !!}
        <!--external css-->
        {!! Html::style('/assets/admin/assets/font-awesome/css/font-awesome.css') !!}
        {!! Html::style('/assets/admin/assets/jquery-ui/jquery-ui-1.10.1.custom.min.css') !!}
        <!--right slidebar-->
        {!! Html::style('/assets/admin/css/slidebars.css') !!}
        <!-- Custom styles for this template -->
        {!! Html::style('/assets/admin/css/style.css') !!}
        {!! Html::style('/assets/admin/css/style-responsive.css') !!}
        {!! Html::style('/assets/admin/css/jquery.bxslider.css') !!}
        {!! Html::style('/assets/admin/css/base.css') !!}

        {!! Html::style('/assets/admin/css/custom.css') !!}
        {!! Html::style('/assets/admin/css/jquery.tooltip.css') !!}
        {!! Html::style('/assets/admin/css/toastr.css') !!}

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
            <script src="assets/admin/js/html5shiv.js"></script>
            <script src="assets/admin/js/respond.min.js"></script>
        <![endif]-->
        <script src="/assets/admin/js/jquery.min.js"></script>
    </head>
    <body>
        <section id="container">
            <!--header start-->
            @include('masters.client.header')
            <!--header end-->
            <!--main content start-->
            <section id="content">
                <section class="wrapper">
                    @yield('content')
                </section>
            </section>
            <!--main content end-->
            <!--footer start-->
            @include('masters.client.footer')
            <!--footer end-->
        </section>
        {!! Html::script('/assets/admin/js/bootstrap.min.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.dcjqaccordion.2.7.js'); !!}
        {!! Html::script('/assets/admin/js/bootstrap-switch.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.tagsinput.js'); !!}
        {!! Html::script('/assets/admin/js/hover-dropdown.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.scrollTo.min.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.nicescroll.js'); !!}
        {!! Html::script('/assets/admin/js/jquery-ui-1.9.2.custom.min.js'); !!}
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        {!! Html::script('/assets/admin/js/respond.min.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-datepicker/js/bootstrap-datepicker.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-daterangepicker/date.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-daterangepicker/moment.min.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-daterangepicker/daterangepicker.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js'); !!}
        {!! Html::script('/assets/admin/assets/bootstrap-timepicker/js/bootstrap-timepicker.js'); !!}

        <!--right slidebar-->
        {!! Html::script('/assets/admin/js/slidebars.min.js'); !!}
        {!! Html::script('/assets/admin/assets/advanced-datatable/media/js/jquery.dataTables.js'); !!}
        <!--common script for all pages-->
        {!! Html::script('/assets/admin/js/common-scripts.js'); !!}
        {!! Html::script('/assets/admin/js/form-component.js'); !!}
        <!--{!! Html::script('/assets/admin/js/products.js'); !!}-->

        {!! Html::script('/assets/admin/js/custom.js'); !!}
        <!--{!! Html::script('/assets/admin/js/morris-script.js'); !!}-->
        
        <!--{!! Html::script('/assets/admin/js/jquery.tooltip.js'); !!}-->
        {!! Html::script('/assets/admin/js/jquery.validate.min.js'); !!}
        {!! Html::script('/assets/admin/js/toastr.js'); !!}
       
        {!! Html::script('/assets/admin/js/bootstrap-typeahead.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.confirm.js'); !!}
        {!! Html::script('/assets/admin/js/auto-complete.min.js'); !!}
        {!! Html::script('/assets/admin/js/common.js'); !!}
        {!! Html::script('/assets/admin/js/manage-products.js'); !!}
        <script type="text/javascript">
        $(document).ready(function(){
            var type = '';
            var msg =  '';
            var title =  'Thông báo';
            @if(Session::has('flashInfo'))
                type = "{{ Session::get('alert-class', 'info') }}";
                msg= "{{ Session::get('flashInfo') }}";
                notification(type, msg, title);
            @elseif(Session::has('flashSuccess'))
                type = "{{ Session::get('alert-class', 'success') }}";
                msg= "{{ Session::get('flashSuccess') }}";
                notification(type, msg, title);
            @elseif(Session::has('flashWarning'))
                type = "{{ Session::get('alert-class', 'warning') }}";
                msg= "{{ Session::get('flashWarning') }}";
                notification(type, msg, title);
            @elseif(Session::has('flashError'))
                type = "{{ Session::get('alert-class', 'error') }}";
                msg= "{{ Session::get('flashError') }}";
                notification(type, msg, title);
            @endif
        });
        </script>
    </body>
    <!-- Mirrored from thevectorlab.net/flatlab/product_list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 11 Jun 2016 01:35:27 GMT -->
</html>
