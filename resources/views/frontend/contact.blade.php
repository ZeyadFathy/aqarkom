@extends('frontend.layouts.app')
@section('PageTitle','تواصل معانا')
@section('content')
    <!-- Content ================================================== -->
    <!-- Map Container -->
    <div class="contact-map margin-bottom-55">

{{--        <!-- Google Maps -->--}}
{{--        <div class="google-map-container">--}}
{{--            <div id="propertyMap" data-latitude="40.7427837" data-longitude="-73.11445617675781"></div>--}}
{{--            <a href="#" id="streetView">Street View</a>--}}
{{--        </div>--}}
{{--        <!-- Google Maps / End -->--}}

{{--        <!-- Office -->--}}
{{--        <div class="address-box-container">--}}
{{--            <div class="address-container" data-background-image="{{url('frontend/')}}/images/our-office.jpg">--}}
{{--                <div class="office-address">--}}
{{--                    <h3>Our Office</h3>--}}
{{--                    <ul>--}}
{{--                        <li>45 Park Avenue, Apt. 303</li>--}}
{{--                        <li>New York, NY 10016</li>--}}
{{--                        <li>Phone (123) 123-456</li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <!-- Office / End -->

    </div>
    <div class="clearfix"></div>
    <!-- Map Container / End -->
    <br>
    <!-- Container / Start -->
    <div class="container">

        <div class="row">

{{--            <!-- Contact Details -->--}}
{{--            <div class="col-md-4">--}}

{{--                <h4 class="headline margin-bottom-30">Find Us There</h4>--}}

{{--                <!-- Contact Details -->--}}
{{--                <div class="sidebar-textbox">--}}
{{--                    <p>Collaboratively administrate turnkey channels whereas virtual e-tailers. Objectively seize scalable metrics whereas proactive e-services.</p>--}}

{{--                    <ul class="contact-details">--}}
{{--                        <li><i class="im im-icon-Phone-2"></i> <strong>Phone:</strong> <span>(123) 123-456 </span></li>--}}
{{--                        <li><i class="im im-icon-Fax"></i> <strong>Fax:</strong> <span>(123) 123-456 </span></li>--}}
{{--                        <li><i class="im im-icon-Globe"></i> <strong>Web:</strong> <span><a href="#">www.example.com</a></span></li>--}}
{{--                        <li><i class="im im-icon-Envelope"></i> <strong>E-Mail:</strong> <span><a href="#">Info@aqarito.com</a></span></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--            </div>--}}

            <!-- Contact Form -->
            <div class="col-md-8">

                <section id="contact">
                    <h4 class="headline margin-bottom-35">@lang('app.contactus')</h4>

                    <div id="contact-message"></div>

                    <form method="post" action="{{ route('contactus.store') }}" name="contactform" id="contactform" autocomplete="on">
                        {{ csrf_field() }}
                        <div>
                            <input name="title" type="text" id="title" placeholder="@lang('app.subject_message')" required="required"/>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <input name="email" type="email" id="email" placeholder="@lang('app.e-mail')"
                                           pattern="^[A-Za-z0-9](([_\.\-]?[a-zA-Z0-9]+)*)@([A-Za-z0-9]+)(([\.\-]?[a-zA-Z0-9]+)*)\.([A-Za-z]{2,})$" required="required"/>
                                </div>
                            </div>
                        </div>
                        <div>
                            <textarea name="message" cols="40" rows="3" id="comments" placeholder="@lang('app.message')" spellcheck="true" required="required"></textarea>
                        </div>
                        <input type="submit" class="submit button" id="submit" value="@lang('app.send_message')"/>
                    </form>
                </section>
            </div>
            <!-- Contact Form / End -->

        </div>

    </div>
    <!-- Container / End -->
@stop
