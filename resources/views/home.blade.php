
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="description" content="Responsive Bootstrap Multi-Purpose Landing Page Template">
<meta name="keywords" content="LandX, Bootstrap, Landing page, Template, Registration, Landing">
<meta name="author" content="Mizanur Rahman">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!-- SITE TITLE -->
<title>LandX - Responsive Multi-Purpose Landing Page</title>

<!-- =========================
      FAV AND TOUCH ICONS  
============================== -->
<link rel="icon" href="/assets/client/images/favicon.ico">
<link rel="apple-touch-icon" href="/assets/client/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="/assets/client/images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="/assets/client/images/apple-touch-icon-114x114.png">

<!-- =========================
     STYLESHEETS   
============================== -->
<!-- BOOTSTRAP -->
<link rel="stylesheet" href="/assets/client/css/bootstrap.min.css">

<!-- FONT ICONS -->
<!-- IonIcons -->
<link rel="stylesheet" href="/assets/client/css/ionicons.css">

<!-- Font Awesome 
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
-->

<!-- Elegant Icons -->
<link rel="stylesheet" href="/assets/client/css/style.css">
<!--[if lte IE 7]><script src="assets/elegant-icons/lte-ie7.js"></script><![endif]-->



<!-- CAROUSEL AND LIGHTBOX -->
<link rel="stylesheet" href="/assets/client/css/owl.theme.css">
<link rel="stylesheet" href="/assets/client/css/owl.carousel.css">
<link rel="stylesheet" href="/assets/client/css/nivo-lightbox.css">
<link rel="stylesheet" href="/assets/client/css/default.css">

<!-- COLORS | CURRENTLY USED DIFFERENTLY TO SWITCH FOR DEMO. IN ORIGINAL FILE ALL COLORS LINK IS COMMENTED EXCEPT BLUE -->
<link rel="stylesheet" href="/assets/client/css/blue.css" title="blue">
<link rel="alternate stylesheet" href="/assets/client/css/green.css" title="green">
<link rel="alternate stylesheet" href="/assets/client/css/orange.css" title="orange">
<link rel="alternate stylesheet" href="/assets/client/css/purple.css" title="purple">
<link rel="alternate stylesheet" href="/assets/client/css/slate.css" title="slate">
<link rel="alternate stylesheet" href="/assets/client/css/yellow.css" title="yellow">
<link rel="alternate stylesheet" href="/assets/client/css/red.css" title="red">
<link rel="alternate stylesheet" href="/assets/client/css/blue-munsell.css" title="blue-munsell">

<!-- CUSTOM STYLESHEETS -->
<link rel="stylesheet" href="/assets/client/css/styles.css">

<!-- RESPONSIVE FIXES -->
<link rel="stylesheet" href="/assets/client/css/responsive.css">

<!--[if lt IE 9]>
			<script src="/assets/client/js/html5shiv.js"></script>
			<script src="/assets/client/js/respond.min.js"></script>
<![endif]-->

<!-- ****************
      After neccessary customization/modification, Please minify HTML/CSS according to http://browserdiet.com/en/ for better performance
     **************** -->

<!-- STYLE SWITCH STYLESHEET ONLY FOR DEMO -->
<link rel="stylesheet" href="/assets/client/css/demo.css">
     
</head>

<body>
<!-- =========================
     PRE LOADER       
============================== -->
<div class="preloader">
  <div class="status">&nbsp;</div>
</div>

<!-- =========================
     HEADER   
============================== -->
<header id="home">
	<!-- COLOR OVER IMAGE -->
	<div class="color-overlay">		
		<div class="navigation-header">			
			<!-- STICKY NAVIGATION -->
			<div class="navbar navbar-inverse bs-docs-nav navbar-fixed-top sticky-navigation">
				<div class="container">
					<div class="navbar-header">					
						<!-- LOGO ON STICKY NAV BAR -->
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#landx-navigation">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><img src="/assets/client/images/logo-dark.png" alt=""></a>					
					</div>				
					<!-- NAVIGATION LINKS -->
					<div class="navbar-collapse collapse" id="landx-navigation">
						<ul class="nav navbar-nav navbar-right main-navigation">
							<li><a href="#home">Trang chủ</a></li>
							<li><a href="#section1">Giới thiệu</a></li>
							<!--<li><a href="#section3">Features</a></li>-->
							<li><a href="#section4">Bản giá</a></li>
							<li><a href="#section5">Video</a></li>
							<li><a href="#section6">Sản phẩm</a></li>
							<li><a href="#section7">Tin tức</a></li>
							<li><a href="#section8">Liên hệ</a></li>
						</ul>
					</div>				
				</div>
				<!-- /END CONTAINER -->			
			</div>		
			<!-- /END STICKY NAVIGATION -->
			
			<!-- ONLY LOGO ON HEADER -->
			<div class="navbar non-sticky">			
				<div class="container">				
					<div class="navbar-header">
						<img src="/assets/client/images/logo.png" alt="">
					</div>
					
					<ul class="nav navbar-nav navbar-right social-navigation hidden-xs">
						<li><a href="#"><i class="social_facebook_circle"></i></a></li>
						<li><a href="#"><i class="social_twitter_circle"></i></a></li>
						<li><a href="#"><i class="social_linkedin_circle"></i></a></li>
					</ul>
					
				</div>
				<!-- /END CONTAINER -->
				
			</div>
			<!-- /END ONLY LOGO ON HEADER -->
			
		</div>
		
		<!-- HEADING, FEATURES AND REGISTRATION FORM CONTAINER -->
		<div class="container">		
			<div class="row">			
				<!-- LEFT - HEADING AND TEXTS -->
				<div class="col-md-10 col-md-offset-1 intro-section">				
					<h1 class="intro">Phần mềm quản lý bán hàng <span class="strong colored-text">Nam Việt</span></h1>				
					<p class="sub-heading">
					    Nam Việt - Phần mềm quản lý bán hàng phổ biến nhất với 100 cửa hàng đang sử dụng. Đơn giản, dễ dùng, tiết kiệm chi phí và phù hợp với hơn 10 ngành hàng khác nhau.
					</p>
				</div>
			</div>		
			<!-- SUBSCRIBE FORM -->
			<div class="row">
			    <div class="col-md-6 col-md-offset-3">		        
			        <div class="sf-container">
					<form class="subscription-form mailchimp form-inline" role="form">				
						<!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
						<h6 class="subscription-success"></h6>
						<h6 class="subscription-error"></h6>
						<!-- SUBSCRIBE BUTTON -->
						<button type="btn" id="subscribe-button1" class="btn standard-button">Dùng thử miễn phí</button>				
					</form>
					</div>
			        
			    </div>
			</div>
			
		</div>
		<!-- /END HEADING, FEATURES AND REGISTRATION FORM CONTAINER -->	
	</div>
</header>


<!-- =========================
     SECTION 1   
============================== -->
<section class="section1" id="section1">
	<div class="container">
		<div class="row">			
			<div class="col-md-6">				
				<!-- SCREENSHOT -->
				<div class="side-screenshot pull-left">
					<img src="/assets/client/images/image-1.jpg" alt="Feature" class="img-responsive">
				</div>				
			</div>			
			<div class="col-md-6">				
				<div class="brief text-left">
					<h2>Tại sao bạn thích phần mềm bán hàng Nam Việt?</h2>
					<ul class="feature-list-2">						
						<li>
							<div class="icon-container pull-left">
								<span class="icon_cog"></span>
							</div>
							<div class="details pull-left">
								<h6>Đơn giản & Dễ dùng</h6>
								<p>Nhân viên bán hàng chỉ mất 15 phút làm quen để bắt đầu bán hàng với Nam Việt. Giao diện đơn giản, thân thiện, thông minh giúp bạn triển khai quản lý bán hàng thật dễ dàng và nhanh chóng.</p>
							</div>
							</li>							
						<li>
							<div class="icon-container pull-left">
								<span class="icon_compass_alt"></span>
							</div>
							<div class="details pull-left">
								<h6>Phù hợp cho từng ngành hàng</h6>
								<p>Cùng với các chuyên gia bán hàng dày kinh nghiệm, chúng tôi nghiên cứu thiết kế phần mềm phù hợp đến hơn 10 ngành hàng dành cho cả bán buôn lẫn bán lẻ.</p>
							</div>
						</li>							
						<li>
							<div class="icon-container pull-left">
								<span class="icon_cart_alt"></span>
							</div>
							<div class="details pull-left">
								<h6>Tiết kiệm chi phí nhất</h6>
								<p>Miễn phí cài đặt, phí triển khai, nâng cấp và hỗ trợ. Rẻ hơn một ly trà đá, chỉ với 3.000 đồng/ngày, bạn đã có thể áp dụng công nghệ vào quản lý cửa hàng.</p>
							</div>
						</li>
					</ul>
				</div>
			</div>			
		</div> <!-- END ROW -->		
	</div> <!-- END CONTAINER -->
</section>
<!-- =========================
     SECTION 2   
============================== -->
<!--<section class="section2 bgcolor-2" id="section2">
	<div class="container">		
		<div class="row">			
			<div class="col-md-6">
				<div class="brief text-left">					
					<h2>Describe more about product</h2>
					<div class="colored-line pull-left">
					</div>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut.
					</p>
					<ul class="feature-list-2">					
						<li>
						<div class="icon-container pull-left">
							<span class="icon_cog"></span>
						</div>
						<div class="details pull-left">
							<h6>Easy to Customize</h6>
							<p>
								Lorem lean startup ipsum product market fit customer development acquihire technical cofounder.
							</p>
						</div>
						</li>
						<li>
						<div class="icon-container pull-left">
							<span class="icon_cart_alt"></span>
						</div>
						<div class="details pull-left">
							<h6>Lorem Ipsum</h6>
							<p>
								Lorem lean startup ipsum product market fit customer development acquihire technical cofounder.
							</p>
						</div>
						</li>
					</ul>
				</div>
			</div>			
			<div class="col-md-6">
				<div class="side-screenshot2 pull-right">
					<img src="/assets/client/images/image-2.jpg" alt="Feature" class="img-responsive">
				</div>
			</div>
		</div>
	</div>
</section>-->

<!-- =========================
     SECTION 3   
============================== -->
<!--<section class="section3" id="section3">
	<div class="container">	
		<h2>LandX Features</h2>
		<div class="colored-line"></div>
		
		<div class="sub-heading">
			Term sheet convertible note colluding bootstrapping.
		</div>
		<div class="features">
			<div class="row">
				<div class="col-md-4">
					<div class="feature">
						<div class="icon">
							<span class="icon_compass_alt"></span>
						</div>
						<h4>Responsive Design</h4>
						<p>
							Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement.
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="feature">
						<div class="icon">
							<span class="icon_map_alt"></span>
						</div>
						<h4>350+ Font Icons</h4>
						<p>
							Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement.
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="feature">
						<div class="icon">
							<span class="icon_gift_alt"></span>
						</div>
						<h4>Built with Bootstrap 3.1</h4>
						<p>
							Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement.
						</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="feature">
						<div class="icon">
							<span class="icon_adjust-vert"></span>
						</div>
						<h4>Easy to Customize</h4>
						<p>
							Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement.
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="feature">
						<div class="icon">
							<span class="icon_tags_alt"></span>
						</div>
						<h4>Lots of Variations</h4>
						<p>
							Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement.
						</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="feature">
						<div class="icon">
							<span class="icon_chat_alt"></span>
						</div>
						<h4>24/7 Chat Support</h4>
						<p>
							Lorem lean startup ipsum product market fit customer development acquihire technical cofounder. User engagement.
						</p>
					</div>
				</div>
			</div> 
		</div>
	</div>
</section>-->
<!-- =========================
     SECTION 4   
============================== -->
<section class="section4 bgcolor-2" id="section4">
<div class="container">
	
	<!-- SECTION HEADING -->
	<h2>BẢNG PHÍ DỊCH VỤ</h2>
	<div class="colored-line"></div>	

	<div class="pricing-table">
		
		<!-- PRICING TABLES -->
		<div class="row">
			
			<!-- PACKAGE ONE -->
			<div class="col-md-4">
				<div class="package bgcolor-white">
					<div class="header dark-bg">
						<h3>MIỄN PHÍ</h3>
						<div class="sub-heading">
							<span class="colored-text strong">01đ</span> Tháng
						</div>
					</div>					
					<!-- PACKAGE FEATURES -->
					<div class="package-features">
						<ul>
							<li>
							<div class="column-9p">
								Total Users
							</div>
							<div class="column-1p">
								5
							</div>
							</li>
							<li>
							<div class="column-9p">
								Unlimited Styles
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Advance Protection
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Cloud Storage
							</div>
							<div class="column-1p">
								<span class="icon_close"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								24/7 Customer Service
							</div>
							<div class="column-1p">
								<span class="icon_close"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Backup Service
							</div>
							<div class="column-1p">
								<span class="icon_close"></span>
							</div>
							</li>
						</ul>
						<div class="bottom-row">
							<div class="column-7p">
								<h6>$39 Per Month</h6>
							</div>
							<div class="column-3p">
								<div id="cta-1">
									<a href="#home" class="btn secondary-button">SIGN UP</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
			<!-- PACKAGE TWO -->
			<div class="col-md-4">
				<div class="package bgcolor-white">
					<div class="header color-bg">
						<h3>GÓI CƠ BẢN</h3>
						<div class="sub-heading">
							<span class=" strong">90.000đ</span> Tháng
						</div>
					</div>					
					<!-- PACKAGE FEATURES -->
					<div class="package-features">
						<ul>
							<li>
							<div class="column-9p">
								Total Users
							</div>
							<div class="column-1p">
								35
							</div>
							</li>
							<li>
							<div class="column-9p">
								Unlimited Styles
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Advance Protection
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Cloud Storage
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								24/7 Customer Service
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Backup Service
							</div>
							<div class="column-1p">
								<span class="icon_close"></span>
							</div>
							</li>
						</ul>
						<div class="bottom-row">
							<div class="column-7p">
								<h6>$59 Per Month</h6>
							</div>
							<div class="column-3p">
								<div id="cta-2">
									<a href="#home" class="btn standard-button">SIGN UP</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- /END PACKAGE -->
			
			<!-- PACKAGE THREE -->
			<div class="col-md-4">
				<div class="package bgcolor-white">
					<div class="header dark-bg">
						<h3>GÓI NÂNG CAO</h3>
						<div class="sub-heading">
							<span class="colored-text strong">150.000đ</span> Tháng
						</div>
					</div>
					
					<!-- PACKAGE FEATURES -->
					<div class="package-features">
						<ul>
							<li>
							<div class="column-9p">
								Unlimited Users
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Unlimited Styles
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Advance Protection
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Cloud Storage
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								24/7 Customer Service
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
							<li>
							<div class="column-9p">
								Backup Service
							</div>
							<div class="column-1p">
								<span class="icon_check"></span>
							</div>
							</li>
						</ul>
						<div class="bottom-row">
							<div class="column-7p">
								<h6>$99 Per Month</h6>
							</div>
							<div class="column-3p">
								<div id="cta-3">
									<a href="#home" class="btn secondary-button">SIGN UP</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- /END PACKAGE -->
			
			
		</div> <!-- /END ROW -->
	</div> <!-- /END ALL PACKAGE -->
	
</div> <!-- /END CONTAINER -->

</section>
<!-- =========================
     SECTION 5   
============================== -->
<section class="section5" id="section5">

<div class="container">
	
	<!-- SECTION HEADING -->
	<h2>Watch Video</h2>
	<div class="colored-line">
	</div>
	
	<div class="sub-heading">
		Term sheet convertible note colluding bootstrapping.
	</div>
	
	<!-- VIDEO -->
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			
			<div class="video-container">
				
                <!--
				<div class="video">
					
					<iframe src="//player.vimeo.com/video/88902745?byline=0&amp;portrait=0&amp;color=ffffff" width="600" height="338" frameborder="0" allowfullscreen>
					</iframe> 
				</div>
				-->
				
				<div class="video">
					
					<iframe width="640" height="360" src="//www.youtube.com/embed/PtJBVhkL1Eg?rel=0" frameborder="0" allowfullscreen></iframe>
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- FEATURES IN VIDEO SECTION -->
	<div class="row video-features">
		<div class="col-md-10 col-md-offset-1">
			<div class="row">
				<div class="col-md-4 col-sm-4">
					<h5>
					<span class="ion-android-contacts colored-text inline-icon"></span> Trusted by 100+ users </h5>
				</div>
				<div class="col-md-4 col-sm-4">
					<h5>
					<span class="ion-android-earth colored-text inline-icon"></span> WorldWide Access </h5>
				</div>
				<div class="col-md-4 col-sm-4">
					<h5>
					<span class="ion-android-forums colored-text inline-icon"></span> 24/7 Chat Support </h5>
				</div>
			</div>
		</div>
	</div> <!-- /END FEATURES IN VIDEO SECTION -->
	
</div> <!-- /END CONTAINER -->

</section>

<!-- =========================
     SECTION 6   
============================== -->
<section class="section6 bgcolor-2" id="section6">
<div class="container">
	
	<!-- SECTION HEADING -->
	<h2>Screenshots</h2>
	<div class="colored-line">
	</div>
	
	<div class="sub-heading">
		Term sheet convertible note colluding bootstrapping.
	</div>
	
	<!-- SCREENSHOTS -->
	<div class="row screenshots">
		
		<div id="screenshots" class="owl-carousel owl-theme">
			
			<div class="shot">
				<a href="/assets/client/images/1.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/client/images/1.jpg" alt="Screenshot"></a>
			</div>
			
			<div class="shot">
				<a href="/assets/client/images/3.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/client/images/3.jpg" alt="Screenshot"></a>
			</div>
			
			<div class="shot">
				<a href="/assets/client/images/2.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/client/images/2.jpg" alt="Screenshot"></a>
			</div>
			
			<div class="shot">
				<a href="/assets/client/images/2.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/client/images/2.jpg" alt="Screenshot"></a>
			</div>
			
			<div class="shot">
				<a href="/assets/client/images/1.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/client/images/1.jpg" alt="Screenshot"></a>
			</div>
			
			<div class="shot">
				<a href="/assets/client/images/2.jpg" data-lightbox-gallery="screenshots-gallery"><img src="/assets/client/images/2.jpg" alt="Screenshot"></a>
			</div>
		</div>
		
	</div> <!-- /END SCREENSHOTS -->
	
</div> <!-- /END CONTAINER -->

</section>

<!-- =========================
     SECTION 7  
============================== -->
<section class="section7" id="section7">
<div class="container">
	
	<!-- SECTION HEADING -->
	<h2>Trusted by Thousands</h2>
	<div class="colored-line">
	</div>
	
	<div class="sub-heading">
		Term sheet convertible note colluding bootstrapping.
	</div>
	
	<!-- CLIENTS -->
	<div class="row clients">
		<div class="col-md-12 col-sm-12">
			<ul class="client-logos">
				<li><a href=""><img src="/assets/client/images/client_1.png" alt=""></a></li>
				<li><a href=""><img src="/assets/client/images/client_2.png" alt=""></a></li>
				<li><a href=""><img src="/assets/client/images/client_3.png" alt=""></a></li>
				<li><a href=""><img src="/assets/client/images/client_4.png" alt=""></a></li>
			</ul>
		</div>
	</div>
	
	<!-- TESTIMONIALS -->
	<div class="row testimonials">
		
		<!-- FEEDBACKS -->
		<div id="feedbacks" class="owl-carousel owl-theme">
			
			<!-- SINGLE FEEDBACK -->
			<div class="single-feedback">
				<div class="client-pic">
					<img src="/assets/client/images/a.jpg" alt="">
				</div>
				<div class="box">
					<p class="message">
						Sau hơn 1 năm là khách hàng tại Nam Viêt tôi cảm thấy hài lòng về dịch vụ cũng như sự chăm sóc tận tình, hỗ trợ kỹ thuật nhanh, chính xác.
					</p>
				</div>
				<div class="client-info">
					<div class="client-name colored-text strong">
						Phi Phi
					</div>
					<div class="company">
						AbZ Shop
					</div>
				</div>
			</div>
			
			<!-- SINGLE FEEDBACK -->
			<div class="single-feedback">
				<div class="client-pic">
					<img src="/assets/client/images/b.jpg" alt="">
				</div>
				<div class="box">
					<p class="message">
						Sau hơn 1 năm là khách hàng tại Nam Viêt tôi cảm thấy hài lòng về dịch vụ cũng như sự chăm sóc tận tình, hỗ trợ kỹ thuật nhanh, chính xác.
					</p>
				</div>
				<div class="client-info">
					<div class="client-name colored-text strong">Nguyễn Vũ</div>
					<div class="company">Minaworks</div>
				</div>
			</div>
			
			<!-- SINGLE FEEDBACK -->
			<div class="single-feedback">
				<div class="client-pic">
					<img src="/assets/client/images/c.jpg" alt="">
				</div>
				<div class="box">
					<p class="message">
						Dịch vụ chăm sóc khách hàng cũng như chất lượng của Nam Viêt ngày càng nâng cấp tốt hơn, nhân viên tận tình và chuyên nghiệp.
					</p>
				</div>
				<div class="client-info">
					<div class="client-name colored-text strong">
						Lê Dũng
					</div>
					<div class="company">
						Zila shop
					</div>
				</div>
			</div>
			
		</div>
	</div> <!-- /END TESTIMONIALS -->
	
</div>  <!-- /END CONTAINER -->

</section>


<!-- =========================
     SECTION 8 - CTA  
============================== -->
<section class="cta-section" id="section8">
<div class="color-overlay">
	
	<div class="container">
		
		<h4>We Are Ready to Help You</h4>
		<h2>Get the Best Solution for Your Business</h2>
		
		<!-- MAILCHIMP SUBSCRIBE FORM -->
			<form class="subscription-form mailchimp form-inline" role="form">
				
				<!-- SUBSCRIPTION SUCCESSFUL OR ERROR MESSAGES -->
				<h6 class="subscription-success"></h6>
				<h6 class="subscription-error"></h6>
				
				<!-- EMAIL INPUT BOX -->
				<input type="email" name="email" id="subscriber-email" placeholder="Your Email" class="form-control input-box">
				
				<!-- SUBSCRIBE BUTTON -->
				<button type="submit" id="subscribe-button" class="btn standard-button">Subscribe</button>
				
			</form>
			<!-- /END SUBSCRIPTION FORM -->
			
		</div> <!-- /END CONTAINER -->
		
</div>  <!-- /END COLOR OVERLAY -->

</section>

<!-- =========================
     SECTION 9 - CONTACT US  
============================== -->
<section class="contact-us" id="section9">
<div class="container">
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			
			<h3 class="heading">Có cần giúp gì không? Liên hệ ngay!</h3>
			
			<a href="" class="contact-link expand-form"><span class="icon_mail_alt"></span>Liên hệ</a>
			
			<!-- EXPANDED CONTACT FORM -->
			<div class="expanded-contact-form">
				
				<!-- FORM -->
				<form class="contact-form" id="contact" role="form">
					
					<!-- IF MAIL SENT SUCCESSFULLY -->
					<h6 class="success">
					<span class="olored-text icon_check"></span> Your message has been sent successfully. </h6>
					
					<!-- IF MAIL SENDING UNSUCCESSFULL -->
					<h6 class="error">
					<span class="colored-text icon_error-circle_alt"></span> E-mail must be valid and message must be longer than 1 character. </h6>
					
					<div class="field-wrapper col-md-6">
						<input class="form-control input-box" id="cf-name" type="text" name="cf-name" placeholder="Your Name">
					</div>
					
					<div class="field-wrapper col-md-6">
						<input class="form-control input-box" id="cf-email" type="email" name="cf-email" placeholder="Email">
					</div>
					
					<div class="field-wrapper col-md-12">
						<input class="form-control input-box" id="cf-subject" type="text" name="cf-subject" placeholder="Subject">
					</div>
					
					<div class="field-wrapper col-md-12">
						<textarea class="form-control textarea-box" id="cf-message" rows="7" name="cf-message" placeholder="Your Message"></textarea>
					</div>
					
					<button class="btn standard-button" type="submit" id="cf-submit" name="submit" data-style="expand-left">Gửi</button>
				</form>
				<!-- /END FORM -->
			</div>			
		</div>
	</div>	
</div>
</section>
<!-- =========================
     SECTION 10 - FOOTER 
============================== -->
<footer class="bgcolor-2">
<div class="container">	
	<div class="footer-logo">
		<img src="/assets/client/images/logo-dark.png" alt="">
	</div>
	<br>
	<p>CÔNG TY TNHH HỖ TRỢ VÀ PHÁT TRIỂN CÔNG NGHỆ NAM VIỆT LUẬT</p>
	<div class="copyright">©2017 Nam Việt</div>
	
	<ul class="social-icons">
		<li><a href=""><span class="social_facebook_square"></span></a></li>
		<li><a href=""><span class="social_twitter_square"></span></a></li>
		<li><a href=""><span class="social_pinterest_square"></span></a></li>
		<li><a href=""><span class="social_googleplus_square"></span></a></li>
		<li><a href=""><span class="social_instagram_square"></span></a></li>
		<li><a href=""><span class="social_linkedin_square"></span></a></li>
	</ul>
	
</div>
</footer>


		<!-- =========================
		     SCRIPTS   
		============================== -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

		<script>
		/* =================================
		   LOADER                     
		=================================== */
		// makes sure the whole site is loaded
		jQuery(window).load(function() {
		        // will first fade out the loading animation
			jQuery(".status").fadeOut();
		        // will fade out the whole DIV that covers the website.
			jQuery(".preloader").delay(1000).fadeOut("slow");
		})

		</script>

		<script src="/assets/client/js/bootstrap.min.js"></script>
		<script src="/assets/client/js/retina-1.1.0.min.js"></script>
		<script src="/assets/client/js/smoothscroll.js"></script>
		<script src="/assets/client/js/jquery.scrollTo.min.js"></script>
		<script src="/assets/client/js/jquery.localScroll.min.js"></script>
		<script src="/assets/client/js/owl.carousel.min.js"></script>
		<script src="/assets/client/js/nivo-lightbox.min.js"></script>
		<script src="/assets/client/js/simple-expand.min.js"></script>
		<script src="/assets/client/js/jquery.nav.js"></script>
		<script src="/assets/client/js/matchMedia.js"></script>
		<script src="/assets/client/js/jquery.fitvids.js"></script>
		<script src="/assets/client/js/jquery.ajaxchimp.min.js"></script>
		<script src="/assets/client/js/custom.js"></script>
		<!-- ****************
		      After neccessary customization/modification, Please minify JavaScript/jQuery according to http://browserdiet.com/en/ for better performance
		     **************** -->

		<!-- =========================================================
		     STYLE SWITCHER | ONLY FOR DEMO NOT INCLUDED IN MAIN FILES
		============================================================== -->
		<script type="text/javascript" src="/assets/client/js/styleswitcher.js"></script>
		<script type="text/javascript" src="/assets/client/js/demo.js"></script>
		<!--<div class="demo-style-switch" id="switch-style">
			<a id="toggle-switcher" class="switch-button icon_tools"></a>
			<div class="switched-options">
				<div class="config-title">
					Layout Style:
				</div>
				<ul>
					<li><a href="../layout-style-one/index.html">Layout Style One</a></li>
					<li class="active">Layout Style Two <span class="olored-text icon_check"></span></li>
					<li><a href="../layout-style-three/index.html">Layout Style Three</a></li>
					<li><a href="../layout-style-four/index.html">Layout Style Four</a></li>
				</ul>
				
				<div class="config-title">
					Colors :
				</div>
				<ul class="styles">
					<li><a href="#" onclick="setActiveStyleSheet('blue'); return false;" title="Blue">
					<div class="blue">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('purple'); return false;" title="Purple">
					<div class="purple">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('blue-munsell'); return false;" title="Blue Munsell">
					<div class="blue-munsell">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('orange'); return false;" title="Orange">
					<div class="orange">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('slate'); return false;" title="Slate">
					<div class="slate">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('green'); return false;" title="Green">
					<div class="green">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('yellow'); return false;" title="Yellow">
					<div class="yellow">
					</div>
					</a></li>
					
					<li><a href="#" onclick="setActiveStyleSheet('red'); return false;" title="Red">
					<div class="red">
					</div>
					</a></li>
					<li class="p">
						( NOTE: Pre Defined Colors. You can change colors very easily )
					</li>
				</ul>
			</div>
		</div>-->
	</body>
</html>