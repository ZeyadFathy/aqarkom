@extends('frontend.layouts.app')
@section('PageTitle','ارسال استفسار')
@section('content')
    <!-- Content ================================================== -->
    <!-- Map Container -->
    <div class="contact-map margin-bottom-55">
    </div>
    <div class="clearfix"></div>
    <!-- Map Container / End -->
    <!-- Container / Start -->
    <div class="container">

        <div class="row">
            <div class="col-md-8">

                <section id="contact">
                    <h4 class="headline margin-bottom-35">@lang('app.send_inquiry')</h4>

                    <div id="contact-message"></div>

                    <form method="post" action="{{ route('serviceInquiry.store') }}" name="contactform" id="contactform" autocomplete="off">
                        {{ csrf_field() }}
                        <div>
                            <select data-placeholder="@lang('app.select_services')" class="chosen-select-no-single" name="service_id" id="service_id">
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ ((old('service_id') == $service->id) ? 'selected':'') }}>{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div>
                            <input name="city" type="text" id="city" placeholder="@lang('app.city')" required="required"/>
                        </div>
                        <div>
                            <input name="mobile" type="text" id="mobile" placeholder="@lang('app.mobile')" required="required"/>
                        </div>
                        <div>
                            <input name="inquiry" type="text" id="inquiry" placeholder="@lang('app.inquiry')" required="required"/>
                        </div>
                        <input type="submit" class="submit button" id="submit" value="@lang('app.send')"/>
                    </form>
                </section>
            </div>
            <!-- Contact Form / End -->

        </div>

    </div>
    <!-- Container / End -->
@stop
