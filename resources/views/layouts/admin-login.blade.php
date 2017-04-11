<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="img/favicon.html">
        <title>Sales Manager - Login</title>

        <!-- Bootstrap core CSS -->
        {!! Html::style('/assets/admin/css/bootstrap.min.css') !!}
        {!! Html::style('/assets/admin/css/bootstrap-reset.css') !!}
        <!--external css-->
        {!! Html::style('/assets/admin/assets/font-awesome/css/font-awesome.css') !!}
        <!-- Custom styles for this template -->
        {!! Html::style('/assets/admin/css/style.css') !!}
        {!! Html::style('/assets/admin/css/style-responsive.css') !!}

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/admin/js/html5shiv.js"></script>
        <script src="assets/admin/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-body">
        <div class="container">
            @yield('content')
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        {!! Html::script('/assets/admin/js/jquery.js'); !!}
        {!! Html::script('/assets/admin/js/bootstrap.min.js'); !!}
    </body>
</html>
