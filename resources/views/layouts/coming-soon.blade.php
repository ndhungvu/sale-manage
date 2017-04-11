<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TVOnline - Coming Soon</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Lato:400,700'>
        {!! Html::style('/coming-soon/bootstrap/css/bootstrap.min.css') !!}
        {!! Html::style('/coming-soon/font-awesome/css/font-awesome.min.css') !!}
        {!! Html::style('/coming-soon/css/style.css') !!}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        {!! Html::script('/coming-soon/js/jquery-1.11.1.min.js'); !!}
        {!! Html::script('/coming-soon/js/jwplayer.js'); !!}

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.ico">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="coming-soon/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="coming-soon/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="coming-soon/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="coming-soon/ico/apple-touch-icon-57-precomposed.png">
    </head>
    <body>
        <!-- Header -->
        <div class="container">
            <div class="row header">
                <div class="col-sm-4 logo">
                    <h1><a href="index.html">TVOline</a> </h1>
                </div>
                <div class="col-sm-8 call-us">
                    <p>Tel: <span>01697 916 836</span> | Email <span>ndhungvu@gmail.com</span></p>
                </div>
            </div>
        </div>
        @yield('content')
        <!-- Javascript -->
        
        {!! Html::script('/coming-soon/bootstrap/js/bootstrap.min.js'); !!}
        {!! Html::script('/coming-soon/js/jquery.backstretch.min.js'); !!}
        {!! Html::script('/coming-soon/js/jquery.countdown.min.js'); !!}
        {!! Html::script('/coming-soon/js/scripts.js'); !!}
        <!--[if lt IE 10]>
            <script src="coming-soon/js/placeholder.js"></script>
        <![endif]-->
    </body>
</html>