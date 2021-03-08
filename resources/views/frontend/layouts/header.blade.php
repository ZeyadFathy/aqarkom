<!-- Header Container
================================================== -->
<header id="header-container">
    <!-- Topbar -->
    <div id="top-bar">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Top bar -->
                <ul class="top-bar-menu">
                    <li><i class="fa fa-envelope"></i> <a href="mailto: Info@aqarkom.com">Info@aqarkom.com</a></li>
                </ul>

            </div>
            <!-- Left Side Content / End -->


            <!-- Left Side Content -->
            <div class="right-side">

                <!-- Social Icons -->
                <ul class="social-icons">
                    <li><a class="facebook" href="https://www.facebook.com/AqaritoApp/"><i class="icon-facebook"></i></a></li>
                    <li><a class="twitter" href="https://twitter.com/Aqaritoapp"><i class="icon-twitter"></i></a></li>
                    <li><a class="instagram" href="https://www.instagram.com/Aqaritoapp/"><i class="icon-instagram"></i></a></li>
                </ul>

            </div>
            <!-- Left Side Content / End -->

        </div>
    </div>
    <div class="clearfix"></div>
    <!-- Topbar / End -->


    <!-- Header -->
    <div id="header">
        <div class="container">

            <!-- Left Side Content -->
            <div class="left-side">

                <!-- Logo -->
                <div id="logo">
                    <a href="{{ route('home.index') }}"><img src="/logoaq.png" alt="{{ route('home.index') }}"></a>
                </div>


                <!-- Mobile Navigation -->
                <div class="mmenu-trigger">
                    <button class="hamburger hamburger--collapse" type="button">
						<span class="hamburger-box">
							<span class="hamburger-inner"></span>
						</span>
                    </button>
                </div>


                <!-- Main Navigation -->
                <nav id="navigation" class="style-1">
                    <ul id="responsive">
                        <li><a {{ (request()->is('home')  || request()->is('/') ) ? 'class=current' : ''}}  href="{{ route('home.index') }}">@lang('app.home')</a></li>
                        <li><a {{ (request()->is('ads')  || request()->is('ads*') ) ? 'class=current' : ''}}  href="{{ route('ads.index') }}">@lang('app.ads')</a></li>
{{--                        <li><a {{ (request()->is('serviceInquiry')  || request()->is('serviceInquiry*') ) ? 'class=current' : ''}}  href="{{ route('serviceInquiry.index') }}">@lang('app.send_inquiry')</a></li>--}}
                        <li><a {{ (request()->is('contactus')  || request()->is('contactus*') ) ? 'class=current' : ''}}  href="{{ route('contactus.index') }}">@lang('app.contactus')</a></li>
                        <li><a {{ (request()->is('aboutus')  || request()->is('aboutus*') ) ? 'class=current' : ''}}  href="{{ route('aboutus') }}">@lang('app.about_us')</a></li>
                        <li><a {{ request()->is('download') ? 'class=current' : '' }}  href="{{ route('download') }}">@lang('app.featured_ad')</a></li>
                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->

            </div>
            <!-- Left Side Content / End -->

            <div class="right-side">
                <!-- Header Widget -->
                <div class="header-widget">
                    <a href="{{ route('download') }}" class="button border">@lang('app.add_ad')</a>
                </div>
                <!-- Header Widget / End -->
            </div>
        </div>
    </div>
    <!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->
