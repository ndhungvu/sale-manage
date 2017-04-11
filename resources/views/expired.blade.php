<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Mosaddek">
        <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        <link rel="shortcut icon" href="img/favicon.html">

        <title>Sales Manager Coming Soon </title>

        <!-- Bootstrap core CSS -->
        {!! Html::style('/assets/admin/css/bootstrap.min.css') !!}
        {!! Html::style('/assets/admin/css/bootstrap-reset.css') !!}
        <!--external css-->
        {!! Html::style('/assets/admin/assets/font-awesome/css/font-awesome.css') !!}
        <!-- coming soon styles -->
        {!! Html::style('/assets/admin/css/soon.css') !!}    
        <!-- Custom styles for this template -->
        {!! Html::style('/assets/admin/css/style.css') !!}
        {!! Html::style('/assets/admin/css/style-responsive.css') !!}

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="assets/admin/js/html5shiv.js"></script>
        <script src="assets/admin/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="cs-bg">
        <!-- START HEADER -->
        <section id="header">
            <div class="container">
                <header>
                    <!-- HEADLINE -->
                    <a class="logo floatless" href="index-2.html">Seles<span>Manager</span></a>
                    <h1 > Hết hạn dùng.</h1>
                    <br/>
                    <p><h5>Vui lòng liên hệ với chúng tôi qua email ndhungvu@gmail.com hoặc đường dây nóng : 0976412211</h5></p>
                </header>
                <!-- START TIMER -->
                <div id="timer" data-animated="FadeIn">
                    <div id="days" class="timer_box"></div>
                    <div id="hours" class="timer_box"></div>
                    <div id="minutes" class="timer_box"></div>
                    <div id="seconds" class="timer_box"></div>
                </div>
                <!-- END TIMER -->
            </div>
        </section>
        <!-- END HEADER -->
        <!-- Placed at the end of the document so the pages load faster -->
        {!! Html::script('/assets/admin/js/jquery.js'); !!}
        {!! Html::script('/assets/admin/js/modernizr.custom.js'); !!}
        {!! Html::script('/assets/admin/js//bootstrap.min.js'); !!}
        {!! Html::script('/assets/admin/js/soon/plugins.js'); !!}
        {!! Html::script('/assets/admin/js/soon/custom.js'); !!}
    </body>
     <!-- END BODY -->
</html>