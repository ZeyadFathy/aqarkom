@extends('frontend.layouts.app')
@section('PageTitle', trans('app.toc') )
@section('content')

    <!-- Titlebar
================================================== -->
    <div id="titlebar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>{{ trans('app.toc') }}</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Content
    ================================================== -->
    <div class="container">
        <!-- Blockquote
        ================================================== -->
        <div class="row">
            <div class="col-md-12">
                <!-- Headline -->
                {{--                <h4 class="headline with-border margin-top-0 margin-bottom-35">{{ trans('app.about_us') }}</h4>--}}
                <blockquote>
                    {{ isset(\App\Admin\Options\Option::where('key','terms')->first()->value)? \App\Admin\Options\Option::where('key','terms')->first()->value : 'لا يوجد' }}
                </blockquote>
            </div>
        </div>
    </div>
    <div class="margin-top-55"></div>
@stop
