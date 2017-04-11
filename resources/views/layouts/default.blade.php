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
                    <h1 > Coming Soon...</h1>
                    <br/>
                    <p> At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos </p>
                </header>
                <!-- START TIMER -->
                <div id="timer" data-animated="FadeIn">
                    <p id="message"></p>
                    <div id="days" class="timer_box"></div>
                    <div id="hours" class="timer_box"></div>
                    <div id="minutes" class="timer_box"></div>
                    <div id="seconds" class="timer_box"></div>
                </div>
                <!-- END TIMER -->
                <div class="col-lg-4 col-lg-offset-4 mt centered">
                    <h4> LET ME KNOW WHEN YOU LAUNCH</h4>
                    <form class="form-inline" role="form">
                      <div class="form-group">
                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">
                      </div>
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </form>            
                </div>            
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