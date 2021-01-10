		<!-- Header -->
		<header id="wn__header" class="oth-page header__area header__absolute sticky__header">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-7 col-lg-2">
						<div class="logo">
							<a href="{{ route('home') }}">
								<img src="{{ asset('frontend') }}/images/logo/logo.png" alt="logo images">
							</a>
						</div>
					</div>
					<div class="col-lg-8 d-none d-lg-block">
						<nav class="mainmenu__nav">
							<ul class="meninmenu d-flex justify-content-start">
								<li class="drop with--one--item"><a href="{{ route('home') }}">Home</a>
					
									@foreach ($pages as $page)
							
									<li class="drop with--one--item"><a href="{{ route('pages.show',$page->slug) }}">{{ $page->title }}</a>
									@endforeach
								<li class="drop"><a href="javascript:void(0)">Blog</a>
									<div class="megamenu dropdown">
										<ul class="item item01">
											@forelse ($categories as $category)
												<li><a href="{{ route('category.posts',$category->slug) }}">{{ $category->name }}</a></li>
											@empty
												<li><a href="javascript:void(0)"></a></li>
											@endforelse
											
										</ul>
									</div>
								</li>
								<li><a href="{{ route('contact') }}">Contact</a></li>
							</ul>
						</nav>
					</div>
					<div class="col-md-8 col-sm-8 col-5 col-lg-2">
						<ul class="header__sidebar__right d-flex justify-content-end align-items-center">
							<li class="shop_search" style="padding-right: 26px;"><a class="search__active" href="#"></a></li>
							<li class="shopcart" ><a class="cartbox_active" href="#"><span class="product_qun">3</span></a>
								<!-- Start Shopping Cart -->
								<div class="block-minicart minicart__active">
									<div class="minicart-content-wrapper">
										<div class="single__items">
											<div class="miniproduct">
												<div class="item01 d-flex">
													<div class="thumb">
														<a href="product-details.html"><img src="{{ asset('frontend') }}/images/blog/sm-img/1.jpg" alt="product images"></a>
													</div>
													<div class="content">
														<h6><a href="product-details.html">Voyage Yoga Bag</a></h6>
													
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
								<!-- End Shopping Cart -->
							</li>
							
							<li class="setting__bar__icon"><a class="setting__active" href="#"></a>
								<div class="searchbar__content setting__block">
									<div class="content-inner">
									
										{{-- <div class="switcher-options">
											<div class="switcher-currency-trigger">
												<span class="currency-trigger">Fashion Store</span>
												<ul class="switcher-dropdown">
													<li>Furniture</li>
													<li>Shoes</li>
													<li>Speaker Store</li>
													<li>Furniture</li>
												</ul>
											</div>
										</div> --}}
										<div class="switcher-currency">
											<strong class="label switcher-label">
												<span>My Account</span>
											</strong>
											<div class="switcher-options">
												
												<div class="switcher-currency-trigger">
													{{-- <span class="currency-trigger">My Account</span> --}}
													@guest
													<a href="{{ route('login') }}"><span class="currency-trigger">Login</span></a>
													<a href="{{ route('register') }}"><span class="currency-trigger">Register</span></a>
													
													@endguest
													@auth
													<a href="{{ route('user.dashboard') }}"><span class="currency-trigger">Dashboard</span></a>
													<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="currency-trigger">Logout</span></a>
														<form action="{{ route('logout') }}" method="post" class="d-none" id="logout-form">
															@csrf
															<input type="submit" value="logout" class="currency-trigger btn btn-link">
														</form>
													@endauth
												</div>
											</div>
										</div>
									</div>
								</div>
							</li>

							
							
						</ul>
					</div>
				</div>
				<!-- Start Mobile Menu -->
				<div class="row d-none">
					<div class="col-lg-12 d-none">
						<nav class="mobilemenu__nav">
							<ul class="meninmenu">
								<li><a href="{{ route('home') }}">Home</a></li>
								<li><a href="{{ route('pages.show','about-us') }}">About us</a></li>
								<li><a href="{{ route('pages.show','our-vision') }}">Our vision</a></li>
								<li><a href="{{ route('home') }}">Blog</a>
									<ul>
									@forelse ($categories as $category)
										<li><a href="javascript:void(0)">{{ $category->name }}</a></li>
									@empty
										<li><a href="javascript:void(0)"></a></li>
									@endforelse
									</ul>
								</li>
								<li><a href="contact.html">Contact</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- End Mobile Menu -->
	            <div class="mobile-menu d-block d-lg-none">
	            </div>
	            <!-- Mobile Menu -->	
			</div>		
		</header>
		<!-- //Header -->
		<!-- Start Search Popup -->
		<div class="box-search-content search_active block-bg close__top">
			<form id="search_mini_form" class="minisearch" action="#">
				<div class="field__search">
					<input type="text" placeholder="Search entire store here...">
					<div class="action">
						<a href="#"><i class="zmdi zmdi-search"></i></a>
					</div>
				</div>
			</form>
			<div class="close__wrap">
				<span>close</span>
			</div>
		</div>
		<!-- End Search Popup -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area bg-image--4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bradcaump__inner text-center">
                        	<h2 class="bradcaump-title">Blog Page</h2>
                            <nav class="bradcaump-content">
                              <a class="breadcrumb_item" href="index.html">Home</a>
                              <span class="brd-separetor">/</span>
                              <span class="breadcrumb_item active">Blog</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->