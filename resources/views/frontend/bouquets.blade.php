@extends('frontend.layouts.app')

@section('PageTitle', 'Aqarito - Bouquets' )

@section('content')
    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="headline margin-bottom-25 margin-top-65">الباقات</h3>
                <div class="row bouquets">
                    @foreach($bouquets as $bouquet)
                        <div class="col-md-4">
                            <div class="bouquet" style="background-color: {{$bouquet->color}}">
                                <h3>{{$bouquet->name_ar}}</h3>
                                <h3 class="price">{{$bouquet->price}} ريال</h3>
                                <hr>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>فترة صلاحية الباقة</td>
                                            <td>{{$bouquet->period}} شهر</td>
                                        </tr>
                                        <tr>
                                            <td>عقارات المعلن</td>
                                            <td>{{$bouquet->ads_number}} اعلان</td>
                                        </tr>
                                        <tr>
                                            <td>خدمة التصوير</td>
                                            <td>{{$bouquet->photos_services}} خدمة</td>
                                        </tr>
                                        <tr>
                                            <td>التواصل الاجتماعى</td>
                                            <td>{{$bouquet->social_media}}</td>
                                        </tr>
                                        <tr>
                                            <td>اعلان مميز</td>
                                            <td>{{$bouquet->featured_ads_number}} اعلان</td>
                                        </tr>
                                        <tr>
                                            <td>الاشعارات</td>
                                            <td>{{$bouquet->mobile_notification}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h5>{{$bouquet->free_period}} شهور مجانا</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
