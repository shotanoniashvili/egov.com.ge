@extends('layouts/default')

{{-- Page title --}}
@section('title')
მთავარი
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--page level css starts-->
{{--<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/tabbular.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/animate/animate.min.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/jquery.circliful.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/css/owl.carousel.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/owl_carousel/css/owl.theme.css') }}">--}}

<style>
    .box{
        margin-top:53px !important;
    }

</style>

<!--end of page level css-->
@stop

{{-- slider --}}
{{--@section('top')--}}
{{--<!--Carousel Start -->--}}
{{--<div id="owl-demo" class="owl-carousel owl-theme">--}}
    {{--<div class="item img-fluid"><img src="{{ asset('images/slide_1.jpg') }}" alt="slider-image"/>--}}
    {{--</div>--}}
    {{--<div class="item img-fluid"><img src="{{ asset('images/slide_2.jpg') }}" alt="slider-image">--}}
    {{--</div>--}}
    {{--<div class="item img-fluid"><img src="{{ asset('images/slide_4.png') }}" alt="slider-image">--}}
    {{--</div>--}}
{{--</div>--}}
{{--<!-- //Carousel End -->--}}
{{--@stop--}}

{{-- content --}}
@section('content')
<!-- Layout Section Start -->
<section class="feature-main">
    <div class="container">
        <div class="row">
            <div class="col-12 wow zoomIn" data-wow-duration="2s">
                <div class="layout-image">
                    <img src="{{ asset('images/ge.svg') }}" alt="layout" class="img-fluid"/>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- //Layout Section Start -->
<!-- Accordions Section End -->
    <div class="sliders">
        <!-- Our skill Section start -->
        <div class="container">
            <div class="row">
                <div class="col-sm-6 text-left">
                    <a class="nav-link" href="#">ადმინისტრატორის გვერდი</a>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="nav-link" href="{{ URL::to('contact') }}">კონტაქტი</a>
                </div>
            </div>
            <!-- Our skills Section End -->
        </div>
        <!-- //Our Skills End -->
    </div>

<!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
<!-- page level js starts-->
{{--<script type="text/javascript" src="{{ asset('js/frontend/jquery.circliful.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/wow/js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/frontend/carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/frontend/index.js') }}"></script>--}}
<!--page level js ends-->
@stop


