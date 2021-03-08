@extends('frontend.layouts.app')
@section('PageTitle', $advertisement['title'] )
@section('content')

    <!-- Titlebar
================================================== -->
    <div id="titlebar" class="property-titlebar margin-bottom-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ \Illuminate\Support\Facades\URL::previous() }}" class="back-to-listings"></a>
                    <div class="property-title">
                        <h2>{{ $advertisement['title'] }} <span class="property-badge">{{ \App\Admin\Categories\Category::find($advertisement['category_id'])->title }}</span></h2>
                        <span>
						<a href="#location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							{{ $advertisement['location'] }}
						</a>
                            <a href="#" class="listing-address">
							<i class="fa fa-clock-o"></i>
							{{ \Carbon\Carbon::parse($advertisement['created_at'])->diffForHumans() }}
						</a>
					</span>
                    </div>
                    <div class="property-pricing">
                        <div class="property-price">{{number_format($advertisement['price'])  }} ريال</div>
                        <div class="sub-price"><i class="fa fa-eye"> {{ $views->views }}</i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row margin-bottom-50">
            <div class="col-md-12">
                <!-- Slider -->
                <div class="property-slider default" style="direction:ltr">
                    @if(isset($advertisement['images']) && !is_null($advertisement['images']))
                        @foreach($advertisement['images'] as $image)
                            <a href="https://old-api.aqarito.net/uploads/{{$image}}" data-background-image="https://old-api.aqarito.net/uploads/{{$image}}" class="item mfp-gallery"></a>
                        @endforeach
                    @endif
                </div>
                <!-- Slider Thumbs -->
                <div class="property-slider-nav">
                    @if(isset($advertisement['images']) && !is_null($advertisement['images']))
                        @foreach($advertisement['images'] as $image)
                            <div class="item"><img src="https://old-api.aqarito.net/uploads/{{$image}}" alt="{{$image}}"></div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">

            <!-- Property Description -->
            <div class="col-lg-8 col-md-7">
                <div class="property-description">
                    <ul class="property-main-features">
                        <li>@lang('app.ad_number') : {{ $advertisement['id'] }} </li>
                        <li>@lang('app.mobile_seller') : {{ $advertisement['user']['mobile'] }} </li>
                        <li>@lang('app.area') {{ $advertisement['area'] }} م²</li>
                    </ul>
                    <!-- Description -->
                    <h3 class="desc-headline">@lang('app.description')</h3>
                    <div class="show-more">
                        <p>
                            {{ $advertisement['details'] }}
                        </p>
                        <a href="#" class="show-more-button"> @lang('app.show_more') <i class="fa fa-angle-down"></i></a>
                    </div>

                    <!-- Details -->
                    <h3 class="desc-headline">@lang('app.details')</h3>
                    <ul class="property-features margin-top-0">
                        @if(isset($advertisement['filters']))
                            @foreach($advertisement['filters'] as $addata)
                                <li>{{ isset($addata->title) ? $addata->title : '' }} :
                                    @if($addata->type == 3)
                                        @if(isset($addata->options))
                                            @foreach($addata->options as $options)
                                                <span>{{ isset($options->title) ? $options->title : '' }} ,</span>
                                            @endforeach
                                        @endif
                                    @elseif($addata->type == 1)
                                        <span>{{ isset($addata->text) ? $addata->text : '' }}</span>
                                    @else
                                        @if(isset($addata->options))
                                            @foreach($addata->options as $options)
                                                <span>{{ isset($options->title) ? $options->title : '' }}</span>
                                            @endforeach
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <!-- Location -->
                    <h3 class="desc-headline no-border" id="location">@lang('app.location') - <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ $advertisement['ad_lat'] }},{{$advertisement['ad_long']}}">@lang('app.visit_google_maps')</a></h3>
                    <div id="propertyMap-container">
                        <div id="propertyMap" data-latitude="{{ $advertisement['ad_lat'] }}" data-longitude="{{ $advertisement['ad_long'] }}"></div>
                        <a href="#" id="streetView">@lang('app.StreetView')</a>
                    </div>

                    <!-- Similar Listings Container -->
                    <h3 class="desc-headline no-border margin-bottom-35 margin-top-60">@lang('app.similar_ads')</h3>
                    <!-- Layout Switcher -->
                    <div class="layout-switcher hidden"><a href="#" class="list"><i class="fa fa-th-list"></i></a></div>
                    <div class="listings-container list-layout">
                    @foreach($similar_ads as $similar_ad)
                        <!-- Listing Item -->
                            <div class="listing-item">

                                <a href="{{ route('ads.show',$similar_ad->id) }}" class="listing-img-container">
                                    <div class="listing-badges">
                                        <span>{{ $similar_ad->category->title }}</span>
                                    </div>
                                    <div class="listing-img-content">
                                        <span class="listing-price">{{ number_format($similar_ad->price)  }} ريال</span>
                                        {{--                                        <span class="like-icon"></span>--}}
                                    </div>
                                    <img src="https://old-api.aqarito.net/uploads/{{ isset($similar_ad->images[0]) ? $similar_ad->images[0] : '' }}"
                                         alt="{{ isset($similar_ad->images[0]) ? $similar_ad->images[0] : '' }}">
                                </a>
                                <div class="listing-content">
                                    <div class="listing-title">
                                        <h4><a href="{{ route('ads.show',$similar_ad->id) }}">{{ $similar_ad->title }}</a></h4>
                                        <a href="https://maps.google.com/maps?q={{ $similar_ad->location }}"
                                           class="listing-address popup-gmaps">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $similar_ad->location }}
                                        </a>
                                        <a href="{{ route('ads.show',$similar_ad->id) }}" class="details button border">@lang('app.details')</a>
                                    </div>
                                    <ul class="listing-details">
                                        <li>@lang('app.area') <span>{{ $similar_ad->area }} م²</span></li>
                                    </ul>
                                    <div class="listing-footer">
                                        <a href="#"><i class="fa fa-user"></i> {{ $similar_ad->user->name }}
                                            @if($similar_ad->user->verified)
                                                <img src="{{url('frontend/')}}/images/v-min.png" style="max-height: 25px;max-width: 25px" title="@lang('app.verified')" alt="{{$similar_ad->user->name}}">
                                            @endif
                                        </a>
                                        <span><i class="fa fa-calendar-o"></i> {{ $similar_ad->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <!-- Listing Item / End -->
                            </div>
                            <!-- Listing Item / End -->
                        @endforeach
                    </div>
                    <!-- Similar Listings Container / End -->
                </div>
            </div>
            <!-- Property Description / End -->

            <!-- Sidebar -->
            <div class="col-lg-4 col-md-5">
                <div class="sidebar sticky right">
                    <!-- Widget -->
                    <div class="widget">
                        <h3 class="margin-bottom-35">@lang('app.featured_ads')</h3>

                        <div class="listing-carousel outer">
                        @foreach($featured_ads as $featured_ad)
                            <!-- Item -->
                                <div class="item">
                                    <div class="listing-item compact">

                                        <a href="{{ route('ads.show',$featured_ad->id) }}" class="listing-img-container">

                                            <div class="listing-badges">
                                                @if($featured_ad->featured == 1)
                                                    <span class="featured">@lang('app.featured')</span>
                                                @else
                                                    <span class=""></span>
                                                @endif
                                                <span>{{ $featured_ad->category->title }}</span>
                                            </div>
                                            <div class="listing-img-content">
                                                <span class="listing-compact-title">{{ $featured_ad->title }} <i>{{ number_format($featured_ad->price) }} ريال</i></span>
                                                <ul class="listing-hidden-content">
                                                    <li>@lang('app.area') <span>{{ $featured_ad->area }} م²</span></li>
                                                </ul>
                                            </div>
                                            <img src="https://old-api.aqarito.net/uploads/{{ isset($featured_ad->images[0]) ? $featured_ad->images[0] : '' }}"
                                                 alt="{{ isset($featured_ad->images[0]) ? $featured_ad->images[0] : ''  }}">
                                        </a>
                                    </div>
                                </div>
                                <!-- Item / End -->
                            @endforeach
                        </div>
                    </div>
                    <!-- Widget / End -->
                </div>
            </div>
            <!-- Sidebar / End -->
        </div>
    </div>
    <!-- Footer
    ================================================== -->
    <div class="margin-top-55"></div>
@stop
