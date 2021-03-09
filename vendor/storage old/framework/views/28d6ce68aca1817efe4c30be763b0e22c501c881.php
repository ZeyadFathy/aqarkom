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
                    <li><i class="fa fa-envelope"></i> <a href="mailto: Info@aqarito.com">Info@aqarito.com</a></li>
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
                    <a href="<?php echo e(route('home.index'), false); ?>"><img src="/logoaq.png" alt="<?php echo e(route('home.index'), false); ?>"></a>
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
                        <li><a <?php echo e((request()->is('home')  || request()->is('/') ) ? 'class=current' : '', false); ?>  href="<?php echo e(route('home.index'), false); ?>"><?php echo app('translator')->getFromJson('app.home'); ?></a></li>
                        <li><a <?php echo e((request()->is('ads')  || request()->is('ads*') ) ? 'class=current' : '', false); ?>  href="<?php echo e(route('ads.index'), false); ?>"><?php echo app('translator')->getFromJson('app.ads'); ?></a></li>

                        <li><a <?php echo e((request()->is('contactus')  || request()->is('contactus*') ) ? 'class=current' : '', false); ?>  href="<?php echo e(route('contactus.index'), false); ?>"><?php echo app('translator')->getFromJson('app.contactus'); ?></a></li>
                        <li><a <?php echo e((request()->is('aboutus')  || request()->is('aboutus*') ) ? 'class=current' : '', false); ?>  href="<?php echo e(route('aboutus'), false); ?>"><?php echo app('translator')->getFromJson('app.about_us'); ?></a></li>
                        <li><a <?php echo e(request()->is('download') ? 'class=current' : '', false); ?>  href="<?php echo e(route('download'), false); ?>"><?php echo app('translator')->getFromJson('app.featured_ad'); ?></a></li>
                    </ul>
                </nav>
                <div class="clearfix"></div>
                <!-- Main Navigation / End -->

            </div>
            <!-- Left Side Content / End -->

            <div class="right-side">
                <!-- Header Widget -->
                <div class="header-widget">
                    <a href="<?php echo e(route('download'), false); ?>" class="button border"><?php echo app('translator')->getFromJson('app.add_ad'); ?></a>
                </div>
                <!-- Header Widget / End -->
            </div>
        </div>
    </div>
    <!-- Header / End -->

</header>
<div class="clearfix"></div>
<!-- Header Container / End -->
