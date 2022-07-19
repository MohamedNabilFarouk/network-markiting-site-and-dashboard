<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>shiiry - Ecommerce </title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="{{ asset("site/css/bootstrap.min.css") }}"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="{{ asset("site/css/slick.css") }}"/>
		<link type="text/css" rel="stylesheet" href="{{ asset("site/css/slick-theme.css") }}"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="{{ asset("site/css/nouislider.min.css") }}"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="{{ asset("site/css/font-awesome.min.css") }}">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="{{ asset('site/css/style.css') }}"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

    </head>
	<body>
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container" style='direction:rtl'>
					<ul class="header-links pull-left">
						<li><a href="#"><i class="fa fa-phone"></i> {{$site_settings->phone}}</a></li>
						<li><a href="#"><i class="fa fa-envelope-o"></i> {{$site_settings->email}}</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> {{$site_settings->address_en}}</a></li>
					</ul>
					<ul class="header-links pull-right">
                        @auth
                        <li><a href="#"><i class="fa fa-user"></i>مرحبا  {{auth()->user()->name}}</a></li>
                        @endauth


                        <li><a href="{{route('dashboard')}}"><i class="fa fa-user-o"></i>   @auth حسابي @endauth @guest تسجيل الدخول / مستخدم جديد @endguest</a></li>


					</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="{{url('/')}}" class="logo">
									<img src="{{$site_settings->logo}}" alt="" style="width: 70%;">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

							<!-- SEARCH BAR -->
                            <div class="col-md-6">
                                <div class="header-search">
                                    <form action="{{route('search')}}" method='GET'>
                                        @csrf

                                        <input class="input" name='param' placeholder="ابحث هنا" style="border-radius: 40px 0px 0px 40px;">
                                        <button class="search-btn">بحث</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						{{-- <div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">2</div>
									</a>
								</div>
								<!-- /Wishlist -->

								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="qty">3</div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list">
											<div class="product-widget">
												<div class="product-img">
													<img src="{{asset('site/img/product01.png')}}" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">product name goes here</a></h3>
													<h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
												</div>
												<button class="delete"><i class="fa fa-close"></i></button>
											</div>

											<div class="product-widget">
												<div class="product-img">
													<img src="{{asset('site/img/product02.png')}}" alt="">
												</div>
												<div class="product-body">
													<h3 class="product-name"><a href="#">product name goes here</a></h3>
													<h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
												</div>
												<button class="delete"><i class="fa fa-close"></i></button>
											</div>
										</div>
										<div class="cart-summary">
											<small>3 Item(s) selected</small>
											<h5>SUBTOTAL: $2940.00</h5>
										</div>
										<div class="cart-btns">
											<a href="#">View Cart</a>
											<a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
								<!-- /Cart -->

								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div> --}}
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav nav-center" style='float:right'>
						<li class="active trans"><a href="{{url('/')}}" style="float: right !important;">الرئيسية</a></li>
						<li class="trans"><a href="{{route('shop')}}" style="float: right !important;">المتجر</a></li>
						<li class="trans"><a href="{{route('about')}}" style="float: right !important;">عنا</a></li>
						<li class="trans"><a href="{{route('contact')}}" style="float: right !important;">تواصل معنا</a></li>

					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->
        @yield('content')

        	<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							{{-- <p>سجل حسابك <strong>لاخر الاخبار</strong></p>
							<form>
								<input class="input" type="email" placeholder="بريدك الاكتروني">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> اشترك</button>
							</form> --}}

							<ul class="newsletter-follow">
								@foreach ($social_settings as $s )
                                @if ($s->value != NULL)
                                <li>
									<a href="{{$s->value}}"><i class="fa fa-{{$s->key}}"></i></a>
								</li>
                                @endif

                                @endforeach
                                {{-- <li>
									<a href="{{$social_settings['facebook']}}"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</li> --}}
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /NEWSLETTER -->





		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section" style='direction:rtl'>
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
                            <div class="footer">
                            <img src="{{$site_settings->logo}}" alt="" style="width: 100%;">
                            </div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">  الدفع امن</h3>
								<ul class="footer-links">
									<img src="{{asset('site/img/fawry-pay.png')}}" style='width:44%'>
									<img src="{{asset('site/img/master-visa.png')}}" style='width:44%'>

								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-2 col-xs-6">
							<div class="footer">
								<h3 class="footer-title"><var>روابط</var> </h3>
								<ul class="footer-links">
									<li><a href="{{route('shop')}}">تسوق</a></li>
									<li><a href="{{route('contact')}}">تواصل معنا</a></li>
									<li><a href="{{route('about')}}">عنا</a></li>
									
								</ul>
							</div>
						</div>

						<div class="col-md-4 col-xs-6">
							<div class="footer">
								{{-- <h3 class="footer-title">الدفع امن</h3> --}}
								{{-- <ul class="footer-links">
									<li><a href="#">My Account</a></li>
									<li><a href="#">View Cart</a></li>
									<li><a href="#">Wishlist</a></li>
									<li><a href="#">Track My Order</a></li>
									<li><a href="#">Help</a></li>
								</ul> --}}
                                <div class="footer">
                                    <h3 class="footer-title">عنا</h3>
                                    <p>{{ Str::limit($site_settings->about_des, 100) }}</p>
                                    <ul class="footer-links">

                                        <li><a href="#"><i class="fa fa-map-marker"></i>{{$site_settings->address_en}}</a></li>
                                        <li><a href="#"><i class="fa fa-phone"></i>{{$site_settings->phone}}</a></li>
                                        <li><a href="#"><i class="fa fa-envelope-o"></i>{{$site_settings->email}}</a></li>
                                    </ul>
                                </div>

							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							{{-- <img src="{{asset('site/img/fawry-pay.png')}}" style='width:10%'> --}}
							{{-- <ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul> --}}
							<span class="copyright">
								 <a href="https://www.spctec.com" target="_blank">SPC</a>
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src={{ asset('site/js/jquery.min.js') }}></script>
		<script src={{ asset('site/js/bootstrap.min.js') }}></script>
		<script src={{ asset('site/js/slick.min.js') }}></script>
		<script src={{ asset('site/js/nouislider.min.js') }}></script>
		<script src={{ asset('site/js/jquery.zoom.min.js') }}></script>
		<script src={{ asset('site/js/main.js') }}></script>



	</body>
</html>
