<!-- Flip banner -->
<a  class="flip-banner parallax" data-background="<?php echo e(url('frontend/'), false); ?>/images/flip-banner-bg.jpg" data-color="#32A08E" data-color-opacity="0.9"
   data-img-width="2500" data-img-height="1600">
    <div class="flip-banner-content">
        <h2 class="flip-visible"><?php echo app('translator')->getFromJson('app.download_now'); ?></h2>
        <h2 class="flip-hidden">
            <img  onclick="window.open('https://apple.co/30u2lqs')" width="300" height="75" src="/frontend/images/download-on-app-store.png">
            <img onclick="window.open('http://bit.ly/2GdVU34')" width="300" height="75" src="/frontend/images/Google-Plau-icon.png">
        </h2>
    </div>
</a>
<!-- Flip banner / End -->
<!-- Footer ================================================== -->
<div id="footer" class="sticky-footer">
    <!-- Main -->
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-6" style="float:right">
                <img href="<?php echo e(route('home.index'), false); ?>" class="footer-logo" src="/logoaq.png" alt="<?php echo e(route('home.index'), false); ?>" style="min-height: 50px">
                <br><br>
            </div>
            <div class="col-md-4 col-sm-6 " style="float:right">
                <h4><?php echo app('translator')->getFromJson('app.HelpfulLinks'); ?></h4>
                <ul class="footer-links">
                    <li><a href="<?php echo e(route('aboutus'), false); ?>"><?php echo app('translator')->getFromJson('app.about_us'); ?></a></li>
                    <li><a href="<?php echo e(route('faq'), false); ?>"><?php echo app('translator')->getFromJson('app.faq'); ?></a></li>
                    <li><a href="<?php echo e(route('policy'), false); ?>"><?php echo app('translator')->getFromJson('app.policy'); ?></a></li>
                    <li><a href="<?php echo e(route('toc'), false); ?>"><?php echo app('translator')->getFromJson('app.toc'); ?></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3  col-sm-12">
                <h4><?php echo app('translator')->getFromJson('app.contactus'); ?></h4>
                <div class="text-widget">
                    <?php echo app('translator')->getFromJson('app.e-mail'); ?>: <span> <a href="mailto: Info@aqarito.com">Info@aqarito.com</a> </span><br>
                </div>
                <ul class="social-icons margin-top-20">
                    <li><a class="facebook" href="https://www.facebook.com/AqaritoApp/"><i class="icon-facebook"></i></a></li>
                    <li><a class="twitter" href="https://twitter.com/Aqaritoapp"><i class="icon-twitter"></i></a></li>
                    <li><a class="instagram" href="https://www.instagram.com/Aqaritoapp/"><i class="icon-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- Copyright -->
        <div class="row">
            <div class="col-md-12">
                <div class="copyrights">جميع الحقوق محفوظه <?php echo e(env('app_name'), false); ?>   © <?php echo e(\Carbon\Carbon::now()->format('Y'), false); ?> </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer / End -->
