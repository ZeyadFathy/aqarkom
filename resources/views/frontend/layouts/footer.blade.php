<!-- Flip banner -->
<a {{--href="{{ route('ads.index') }}"--}} class="flip-banner parallax" data-background="{{url('frontend/')}}/images/flip-banner-bg.jpg" data-color="#723B83" data-color-opacity="0.9"
   data-img-width="2500" data-img-height="1600">
    <div class="flip-banner-content">
        <h2 class="flip-visible">@lang('app.download_now')</h2>
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
                <img href="{{ route('home.index') }}" class="footer-logo" src="/logoaqq.png" alt="{{ route('home.index') }}" style="min-height: 50px">
                <br><br>
            </div>
            <div class="col-md-4 col-sm-6 " style="float:right">
                <h4>@lang('app.HelpfulLinks')</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('aboutus') }}">@lang('app.about_us')</a></li>
                    <li><a href="{{ route('faq') }}">@lang('app.faq')</a></li>
                    <li><a href="{{ route('policy') }}">@lang('app.policy')</a></li>
                    <li><a href="{{ route('toc') }}">@lang('app.toc')</a></li>
                    <li><a href="{{ route('refund') }}">سياسة الاسترجاع ورد المدفوعات</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-3  col-sm-12">
                <h4>@lang('app.contactus')</h4>
                <div class="text-widget">
                    @lang('app.e-mail'): <span> <a href="mailto: Info@aqarkom.com">Info@aqarkom.com</a> </span><br>
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
                <div class="copyrights">جميع الحقوق محفوظه {{ env('app_name') }}   © {{ \Carbon\Carbon::now()->format('Y') }} </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer / End -->
