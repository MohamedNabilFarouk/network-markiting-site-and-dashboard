@extends('site.master')
    @section('content')

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					@foreach($section_1 as $s)
                    <!-- shop -->
                    <a href="{{route('details',$s->id)}}">
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="{{asset($s->image)}}" alt="{{$s->name}}" style='max-height: 239px;'>
							</div>
							<div class="shop-body">
                                <h3>{{$s->name}}</h3>
								<a href="{{route('get.checkout',$s->id)}}" class="cta-btn">اشتري الان<i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
                </a>
					<!-- /shop -->

				@endforeach
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12" style="direction:rtl">
						<div class="section-title">
							<h3 class="title">المنتجات الجديدة</h3>
							{{-- <div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab1">Laptops</a></li>
									<li><a data-toggle="tab" href="#tab1">Smartphones</a></li>
									<li><a data-toggle="tab" href="#tab1">Cameras</a></li>
									<li><a data-toggle="tab" href="#tab1">Accessories</a></li>
								</ul>
							</div> --}}
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12 ">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
                                        @foreach ($section_2 as $s)


										<!-- product -->

										<div class="product">
                                            <a href="{{route('details',$s->id)}}">
											<div class="product-img">
												<img src="{{asset($s->image)}}" alt="{{$s->name}}" style='height: 264px;'>
												<div class="product-label">
													{{-- <span class="sale">-30%</span>
													<span class="new">NEW</span> --}}
												</div>
											</div>
                                        </a>
											<div class="product-body">
												{{-- <p class="product-category">Category</p> --}}
												<h3 class="product-name"><a href="{{route('details',$s->id)}}">{{$s->name}}</a></h3>
												<h4 class="product-price">ج.م {{$s->price}} </h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
                                                    {!!  substr(strip_tags($s->des), 0, 50) !!}
													{{-- {{$s->des}} --}}
												</div>
											</div>

											<div class="add-to-cart">
												<a href="{{route('get.checkout',$s->id)}}"><button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> اشتري الان</button></a>
                                                {{-- <a href="#" class="btn btn-primary er fs-6 px-8 py-4" data-bs-toggle="modal" data-bs-target="#kt_modal_new_address">Purchase</a> --}}

                                            </div>
										</div>
										<!-- /product -->





										@endforeach
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section" style="background-image: url({{ $site_settings -> banner }})">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							{{-- <ul class="hot-deal-countdown">
								<li>
									<div>
										<h3>02</h3>
										<span>Days</span>
									</div>
								</li>
								<li>
									<div>
										<h3>10</h3>
										<span>Hours</span>
									</div>
								</li>
								<li>
									<div>
										<h3>34</h3>
										<span>Mins</span>
									</div>
								</li>
								<li>
									<div>
										<h3>60</h3>
										<span>Secs</span>
									</div>
								</li>
							</ul> --}}
							{{-- <h2 class="text-uppercase">hot deal this week</h2> --}}
							{{-- <p>New Collection Up to 50% OFF</p> --}}
							<a class="primary-btn cta-btn" href="{{URL('Shop')}}">تسوق الان</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /HOT DEAL SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12" style="direction:rtl">
						<div class="section-title">
							<h3 class="title">افضل المنتجات</h3>

						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab2" class="tab-pane fade in active">
									<div class="products-slick" data-nav="#slick-nav-2">
										@foreach ($section_3 as $s)


										<!-- product -->
										<div class="product">
                                            <a href="{{route('details',$s->id)}}">
											<div class="product-img">
												<img src="{{asset($s->image)}}" alt="{{$s->name}}" style='height: 264px;'>
												<div class="product-label">
													<span class="sale">-30%</span>
													<span class="new">NEW</span>
												</div>
											</div>
                                        </a>
											<div class="product-body">
												{{-- <p class="product-category">Category</p> --}}
												<h3 class="product-name"><a href="{{route('details',$s->id)}}">{{$s->name}}</a></h3>
												<h4 class="product-price">ج.م {{$s->price}} </h4>
												<div class="product-rating">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
												</div>
												<div class="product-btns">
                                                    {!!  substr(strip_tags($s->des), 0, 50) !!}
													{{-- {{$s->des}} --}}
												</div>
											</div>
											<div class="add-to-cart">
                                                <a href="{{route('get.checkout',$s->id)}}"><button class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> اشتري الان</button></a>

											</div>
										</div>
										<!-- /product -->

										@endforeach







									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- /Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->



	






@stop



