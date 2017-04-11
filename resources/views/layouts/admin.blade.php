<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <meta name="csrf-token" content="{!! csrf_token(); !!}">
        <link rel="shortcut icon" href="/assets/admin/img/favicon.ico">

        <title>Sales Manager</title>

        <!-- Bootstrap core CSS -->
        {!! Html::style('/assets/admin/css/bootstrap.min.css') !!}
        {!! Html::style('/assets/admin/css/bootstrap-reset.css') !!}
        <!--external css-->   
        {!! Html::style('/assets/admin/assets/font-awesome/css/font-awesome.css') !!}
        <!--<link href="assets/admin/css/navbar-fixed-top.css" rel="stylesheet">-->
        {!! Html::style('/assets/admin/assets/bootstrap-datepicker/css/datepicker.css') !!}

        <!-- Custom styles for this template -->
        {!! Html::style('/assets/admin/assets/advanced-datatable/media/css/demo_page.css') !!}
        {!! Html::style('/assets/admin/assets/advanced-datatable/media/css/demo_table.css') !!}
        {!! Html::style('/assets/admin/css/style.css') !!}
        {!! Html::style('/assets/admin/css/style-responsive.css') !!}
        {!! Html::style('/assets/admin/css/custom.css') !!}
        {!! Html::style('/assets/admin/css/jquery.tooltip.css') !!}
        {!! Html::style('/assets/admin/css/toastr.css') !!}

        {!! Html::style('/assets/admin/css/common.css') !!}

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="assets/admin/js/html5shiv.js"></script>
          <script src="assets/admin/js/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
            var webRoot = '{!! \Request::root() !!}';
        </script>
        {!! Html::script('/assets/admin/js/jquery.js'); !!}
    </head>
    <body class="full-width">
        <section id="container" class="">
            <!--header start-->
            @include('masters.admin.header')
            <!--header end-->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                @yield('content')
                </section>
            </section>
            <!--main content end-->
            <!--Footer start-->
            @include('masters.admin.footer')            
            <!--footer end-->
        </section>
        <!-- js placed at the end of the document so the pages load faster -->
        {!! Html::script('/assets/admin/js/bootstrap.min.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.dcjqaccordion.2.7.js'); !!}
        {!! Html::script('/assets/admin/js/bootstrap-switch.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.tagsinput.js'); !!}
        {!! Html::script('/assets/admin/js/hover-dropdown.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.scrollTo.min.js'); !!}
        {!! Html::script('/assets/admin/js/jquery.nicescroll.js'); !!}
        {!! Html::script('/assets/admin/js/jquery-ui-1.9.2.custom.min.js'); !!}
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
       
        {!! Html::script('/assets/admin/js/jquery.confirm.js'); !!}
        {!! Html::script('/assets/admin/js/common.js'); !!}
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
</html>
