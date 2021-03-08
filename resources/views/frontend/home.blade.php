@extends('frontend.layouts.app')

@section('PageTitle', 'AQarKom' )

@section('content')
    <!-- Banner
================================================== -->
    <div class="parallax" data-background="{{url('frontend/')}}/images/home-parallax.jpg" data-color="#36383e" data-color-opacity="0.45" data-img-width="2500" data-img-height="1600">
        <div class="parallax-content">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        <!-- Main Search Container -->
                        <div class="main-search-container">
                            <h2>@lang('app.search_on_the_home_of_your_dreams')</h2>

                            <!-- Main Search -->
                            <form method="post" action="{{ route('ads.store') }}" id="main-search-form" autocomplete="on" class="main-search-form">
                            {{ csrf_field() }}
                            <!-- Type -->
                                <div class="search-type">
                                    <label class="active"><input class="first-tab" name="tab" checked="checked" type="radio">@lang('app.what_you_think_of')</label>
                                    <div class="search-type-arrow"></div>
                                </div>
                                <!-- Box -->
                                <div class="main-search-box">
                                    <!-- Main Search Input -->
                                    <div class="main-search-input larger-input">
                                        <input name="ad_id" type="number" class="ico-01" placeholder="@lang('app.ad_number')" value=""/>
                                        <input name="search" type="text" class="ico-01" placeholder="@lang('app.enter_the_address_for_example_street_city')" value=""/>
                                        <button class="button">@lang('app.search')</button>
                                    </div>

                                    <!-- Row -->
                                    <div class="row with-forms">
                                        <!-- Property Type -->
                                        <div class="col-md-4">
                                            <select data-placeholder="@lang('app.what_are_you_looking_for')" class="chosen-select-no-single" name="category_id">
                                                <option label="blank"></option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{$category->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Min Price -->
                                        <div class="col-md-4">
                                            <!-- Select Input -->
                                            <div class="select-input">
                                                <input name="max_price" type="text" step="1" pattern="[0-9]*" placeholder="@lang('app.max_price')" data-unit="@lang('app.EGP')">
                                            </div>
                                            <!-- Select Input / End -->
                                        </div>
                                        <!-- Max Price -->
                                        <div class="col-md-4">
                                            <!-- Select Input -->
                                            <div class="select-input">
                                                <input name="min_price" type="text" step="1" pattern="[0-9]*" placeholder="@lang('app.min_price')" data-unit="@lang('app.EGP')">
                                            </div>
                                            <!-- Select Input / End -->
                                        </div>
                                    </div>
                                    <!-- Row / End -->
                                </div>
                                <!-- Box / End -->
                            </form>
                            <!-- Main Search -->
                        </div>
                        <!-- Main Search Container / End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="headline margin-bottom-25 margin-top-65">@lang('app.newly_added')</h3>
            </div>
            <!-- Carousel -->
            <div class="col-md-12">
                <div class="carousel">
                @foreach($ads as $ad)
                    <!-- Listing Item -->
                        <div class="carousel-item">
                            <div class="listing-item">
                                <a href="{{ route('ads.show',$ad->id) }}" class="listing-img-container">
                                    <div class="listing-badges">
                                        @if($ad->featured == 1)
                                            <span class="featured">@lang('app.featured')</span>
                                        @else
                                            <span></span>
                                        @endif
                                        <span>{{ $ad->category->title }}</span>
                                    </div>
                                    <div class="listing-img-content">
                                        <span class="listing-price">{{ number_format($ad->price)  }} ريال</span>
                                        {{--                                        <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>--}}
                                        {{--                                        <span class="compare-button with-tip" data-tip-content="Add to Compare"></span>--}}
                                    </div>
                                    <div class="listing-carousel">
                                        @if(isset($ad->images) && !is_null($ad->images))
                                            @foreach($ad->images as $image)
                                                <div>
                                                    <!-- <img style="max-height: 373px; min-height: 373px" src="https://old-api.aqarito.net/uploads/{{$image}}" alt="{{ $image }}"> -->
                                                    <img style="max-height: 373px; min-height: 373px" src="/logo-background.jpg" alt="/logo-background.jpg">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </a>
                                <div class="listing-content">
                                    <div class="listing-title">
                                        <h4><a href="{{ route('ads.show',$ad->id) }}">{{ $ad->title }}</a></h4>
                                        <a href="https://maps.google.com/maps?q={{$ad->location}}"
                                           class="listing-address popup-gmaps">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $ad->location }}
                                        </a>
                                    </div>
                                    <ul class="listing-features">
                                        <li>@lang('app.area') <span>{{ $ad->area }} م²</span></li>
                                    </ul>
                                    <div class="listing-footer">
                                        <a href="#"><i class="fa fa-user"></i> {{ $ad->user->name }}
                                            @if($ad->user->verified)
                                                <img src="{{url('frontend/')}}/images/v-min.png" style="max-height: 25px;max-width: 25px" title="@lang('app.verified')" alt="{{$ad->user->name}}">
                                            @endif
                                        </a>
                                        <span><i class="fa fa-calendar-o"></i> {{ $ad->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Listing Item / End -->
                    @endforeach
                </div>
            </div>
            <!-- Carousel / End -->
        </div>
    </div>
@stop
