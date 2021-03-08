@extends('frontend.layouts.app')
@section('PageTitle','الاعلانات')
@section('content')
    <!-- Search
================================================== -->
    <section class="search margin-bottom-50" style="direction:rtl">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Title -->
                    <h3 class="search-title">@lang('app.search')</h3>
                    <!-- Form -->
                    <!-- Main Search -->
                    <form method="post" action="{{ route('ads.store') }}" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="main-search-box no-shadow">
                            <!-- Row With Forms -->
                            <div class="row with-forms">
                                <div class="col-md-3">
                                    <div class="main-search-input">
                                        <input type="number" id="ad_id" name="ad_id" placeholder="@lang('app.ad_id')" value="{{ request()->get('ad_id') }}"/>
                                    </div>
                                </div>
                                <!-- Status -->
                                <div class="col-md-3">
                                    <select data-placeholder="@lang('app.what_are_you_looking_for')" class="chosen-select-no-single" name="category_id" id="category_id">
                                        <option value="">@lang('app.what_are_you_looking_for')</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ ((request()->get('category_id') == $category->id ) ? 'selected':'') }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Main Search Input -->
                                <div class="col-md-6">
                                    <div class="main-search-input">
                                        <input type="text" id="name" name="search" placeholder="@lang('app.enter_the_address_for_example_street_city')" value="{{ request()->get('search') }}"/>
                                        <button type="submit" class="button">@lang('app.search')</button>
                                    </div>
                                </div>

                            </div>
                            <!-- Row With Forms / End -->
                            <!-- Row With Forms -->
                            <div class="row with-forms">

                                <!-- Min Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="@lang('app.min_area')" name="min_area" data-unit="م²" value="{{ request()->get('min_area') }}">
                                        <select>
                                            <option>@lang('app.min_area')</option>
                                            <option>300</option>
                                            <option>400</option>
                                            <option>500</option>
                                            <option>700</option>
                                            <option>800</option>
                                            <option>1000</option>
                                            <option>1500</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->

                                </div>

                                <!-- Max Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="@lang('app.max_area')" data-unit="م²" name="max_area" value="{{ request()->get('max_area') }}">
                                        <select>
                                            <option>@lang('app.max_area')</option>
                                            <option>300</option>
                                            <option>400</option>
                                            <option>500</option>
                                            <option>700</option>
                                            <option>800</option>
                                            <option>1000</option>
                                            <option>1500</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->

                                </div>


                                <!-- Min Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="@lang('app.min_price')" value="{{ request()->get('min_price') }}" name="min_price" data-unit="ريال">
                                        <select>
                                            <option>@lang('app.min_price')</option>
                                            <option>1000</option>
                                            <option>2000</option>
                                            <option>3000</option>
                                            <option>4000</option>
                                            <option>5000</option>
                                            <option>10000</option>
                                            <option>15000</option>
                                            <option>20000</option>
                                            <option>30000</option>
                                            <option>40000</option>
                                            <option>50000</option>
                                            <option>60000</option>
                                            <option>70000</option>
                                            <option>80000</option>
                                            <option>90000</option>
                                            <option>100000</option>
                                            <option>110000</option>
                                            <option>120000</option>
                                            <option>130000</option>
                                            <option>140000</option>
                                            <option>150000</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->

                                </div>


                                <!-- Max Price -->
                                <div class="col-md-3">

                                    <!-- Select Input -->
                                    <div class="select-input disabled-first-option">
                                        <input type="text" placeholder="@lang('app.max_price')" name="max_price" data-unit="ريال" value="{{ request()->get('max_price') }}">
                                        <select>
                                            <option>@lang('app.max_price')</option>
                                            <option>1000</option>
                                            <option>2000</option>
                                            <option>3000</option>
                                            <option>4000</option>
                                            <option>5000</option>
                                            <option>10000</option>
                                            <option>15000</option>
                                            <option>20000</option>
                                            <option>30000</option>
                                            <option>40000</option>
                                            <option>50000</option>
                                            <option>60000</option>
                                            <option>70000</option>
                                            <option>80000</option>
                                            <option>90000</option>
                                            <option>100000</option>
                                            <option>110000</option>
                                            <option>120000</option>
                                            <option>130000</option>
                                            <option>140000</option>
                                            <option>150000</option>
                                        </select>
                                    </div>
                                    <!-- Select Input / End -->
                                </div>

                            </div>
                            <!-- Row With Forms / End -->
                            <div class="row with-forms">
                                <div class="row margin-bottom-15">
                                    <div class="col-md-6">
                                        <!-- Sort by -->
                                        <div class="sort-by">
                                            <label>ترتيب حسب:</label>
                                            <div class="sort-by-select">
                                                <select data-placeholder="Default order" name="order" class="chosen-select-no-single" id="order">
                                                    <option {{ ((request()->get('order') == 'default') ? 'selected' : '') }} value="default">الترتيب الافتراضي</option>
                                                    <option {{ ((request()->get('order') == 'low') ? 'selected' : '') }} value="low">السعر من الارخص للاعلى</option>
                                                    <option {{ ((request()->get('order') == 'high') ? 'selected' : '') }} value="high">السعر الاعلى الى الادنى</option>
                                                    <option {{ ((request()->get('order') == 'newest') ? 'selected' : '') }} value="newest">أحدث الإعلان</option>
                                                    <option {{ ((request()->get('order') == 'oldest') ? 'selected' : '') }} value="oldest">أقدم إعلان</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Layout Switcher -->
                                        <h6>عدد الاعلانات : {{$ads->count()}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Box / End -->
                </div>
            </div>
        </div>
    </section>

    <!-- Content
    ================================================== -->
    <div class="container">
        <div class="row fullwidth-layout">
            <div class="col-md-12">
                <!-- Sorting / Layout Switcher -->
            {{--                <div class="row margin-bottom-15">--}}
            {{--                    <div class="col-md-6">--}}
            {{--                        <!-- Sort by -->--}}
            {{--                        <div class="sort-by">--}}
            {{--                            <label>Sort by:</label>--}}
            {{--                            <div class="sort-by-select">--}}
            {{--                                <select data-placeholder="Default order" name="order" class="chosen-select-no-single" id="order">--}}
            {{--                                    <option {{ ((request()->get('order') == 'default') ? 'selected' : '') }} value="default">Default Order</option>--}}
            {{--                                    <option {{ ((request()->get('order') == 'low') ? 'selected' : '') }} value="low">Price Low to High</option>--}}
            {{--                                    <option {{ ((request()->get('order') == 'high') ? 'selected' : '') }} value="high">Price High to Low</option>--}}
            {{--                                    <option {{ ((request()->get('order') == 'newest') ? 'selected' : '') }} value="newest">Newest Properties</option>--}}
            {{--                                    <option {{ ((request()->get('order') == 'oldest') ? 'selected' : '') }} value="oldest">Oldest Properties</option>--}}
            {{--                                </select>--}}
            {{--                            </div>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                    <div class="col-md-6">--}}
            {{--                        <!-- Layout Switcher -->--}}
            {{--                        <h6>عدد الاعلانات : {{$ads->count()}}</h6>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            <!-- Listings -->
                <div class="listings-container list-layout">
                    @if($ads->count())
                        @foreach($ads as $ad)
                            <div class="listing-item">
                                <a href="{{ route('ads.show',$ad->id) }}" class="listing-img-container">
                                    <div class="listing-badges">
                                        @if($ad->featured ==1)
                                            <span class="featured">@lang('app.featured')</span>
                                        @else
                                            <span></span>
                                        @endif
                                        <span>{{ $ad->category->title }}</span>
                                    </div>
                                    <div class="listing-img-content">
                                        <span class="listing-price">{{ number_format($ad->price) }} ريال</span>
                                        {{--                                    <span class="like-icon with-tip" data-tip-content="Add to Bookmarks"></span>--}}
                                        {{--                                    <span class="compare-button with-tip" data-tip-content="Add to Compare"></span>--}}
                                    </div>
                                    <div class="listing-carousel">
                                        @if(isset($ad->images) && !is_null($ad->images))
                                            @foreach($ad->images as $image)
                                                <div><img src="/uploads/{{$image}}" alt="{{ $image }}"></div>
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
                                        <a href="{{ route('ads.show',$ad->id) }}" class="details button border">@lang('app.details')</a>
                                    </div>
                                    <ul class="listing-details">
                                        <li>@lang('app.area') <span>{{ $ad->area }} م²</span></li>
                                    </ul>
                                    <div class="listing-footer">
                                        <a href="#"><i class="fa fa-user"></i> {{ $ad->user->name }}
                                            @if($ad->user->verified)
                                                <img src="{{url('frontend/')}}/images/v-min.png" style="max-height: 25px;max-width: 25px" title="@lang('app.verified')" alt="{{ $ad->user->name }}">
                                            @endif
                                        </a>
                                        <span><i class="fa fa-calendar-o"></i> {{ $ad->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 style="text-align: center">
                            @lang('app.no_ads_found')
                        </h3>
                    @endif
                </div>
                <!-- Listings Container / End -->
                <div class="clearfix"></div>
                @if($ads->count())
                    <!-- Pagination -->
                        <div class="pagination-container margin-top-20">
                        <nav class="pagination">
                            <ul>
                                {{ $ads->links()  }}
                            </ul>
                        </nav>
                        <nav class="pagination-next-prev">
                            <ul>
                                <li><a href="{{ $ads->previousPageUrl() }}" class="prev">@lang('app.previous')</a></li>
                                <li><a href="{{ $ads->nextPageUrl() }}" class="next">@lang('app.next')</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Pagination / End -->
                @endif
            </div>

        </div>
    </div>
    <!-- Footer
    ================================================== -->
    <div class="margin-top-55"></div>
@stop
@section('js_after')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#order').change(function (e) {
                var data = '';
                if ('{{ request()->has('ad_id') }}') {
                    data = data + 'ad_id=' + '{{ request()->ad_id }}' + '&';
                }
                if ('{{ request()->has('search') }}') {
                    data = data + 'search=' + '{{ request()->search }}' + '&';
                }
                if ('{{ request()->has('category_id') }}') {
                    data = data + 'category_id=' + '{{ request()->category_id }}' + '&';
                }
                if ('{{ request()->has('max_price') }}') {
                    data = data + 'max_price=' + '{{ request()->max_price }}' + '&';
                }
                if ('{{ request()->has('min_price') }}') {
                    data = data + 'min_price=' + '{{ request()->min_price }}' + '&';
                }
                if ('{{ request()->has('max_area') }}') {
                    data = data + 'max_area=' + '{{ request()->max_area }}' + '&';
                }
                if ('{{ request()->has('min_area') }}') {
                    data = data + 'min_area=' + '{{ request()->min_area }}' + '&';
                }
                if ('{{ request()->has('order') }}') {
                    data = data + 'order=' + '{{ request()->order }}' + '&';
                } else {
                    data = data + 'order=' + $(this).val() + '&';
                }
                console.log(data);
                window.location.href = 'ads?' + data;
            });
        });
    </script>
@stop
