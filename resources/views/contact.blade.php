@extends('layouts/default')

{{-- Page title --}}
@section('title')
კონტაქტი
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/contact.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    <div class="breadcum">
        <div class="container">
            <div class="row">
                <div class="col-12">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}"> <i class="livicon icon3 icon4" data-name="home" data-size="18" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i>მთავარი
                    </a>
                </li>
                <li class="d-none d-lg-block d-sm-block d-md-block">
                    <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                    <a href="#">კონტაქტი</a>
                </li>
            </ol>
            <div class="float-right mt-1">
                <i class="livicon icon3" data-name="cellphone" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> კონტაქტი
            </div>
        </div>
    </div>
        </div>
    </div>
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <div class="row mt-5">
            <!-- Contact form Section Start -->
            <div class="col-md-6 col-lg-6 col-12 my-3">
                <h2>კონტაქტი</h2>
                <!-- Notifications -->
                <div id="notific">
                @include('notifications')
                </div>
                <form class="contact" id="contact" action="{{route('contact')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <input type="text" name="contact-name" class="form-control input-lg" placeholder="თქვენი სახელი" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="contact-email" class="form-control input-lg" placeholder="ელ-ფოსტა" required>
                    </div>
                    <div class="form-group">
                        <textarea name="contact-msg" class="form-control input-lg no-resize resize_vertical" rows="6" placeholder="ტექსტი" required></textarea>
                    </div>
                    <div class="input-group">
                        <button class="btn btn-primary mr-1" type="submit">გაგზავნა</button>

                    </div>
                </form>
            </div>
            <!-- //Conatc Form Section End -->
            <!-- Address Section Start -->
            <div class="col-md-6 col-sm-6" id="address_margt">
                <div class="media media-top media-right">
                    <a href="#">
                        <div class="box-icon">
                            <i class="livicon" data-name="mail-alt" data-size="22" data-loop="true" data-c="#fff" data-hc="#fff"></i>
                        </div>
                    </a>
                    {{--<a href="#">--}}
                        {{--<div class="box-icon">--}}
                            {{--<i class="livicon" data-name="cellphone" data-size="22" data-loop="true" data-c="#fff" data-hc="#fff"></i>--}}
                        {{--</div>--}}
                    {{--</a>--}}
                    <div class="media-body ml-3 mt-2">
                        {{--<h4 class="media-heading">მისამართი:</h4>--}}
{{--                        <div class="danger">Jyostna</div>--}}
                        <address>
                            <p class="mb-4">ელექტრონული მისამართი: bp@nala.ge</p>
                            <p>ტელეფონი: 595 57 77 34</p>

                        </address>
                    </div>
                </div>
            </div>
            <!-- //Address Section End -->
        </div>
    </div>

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="http://maps.google.com/maps/api/js?libraries=places&key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/gmaps/js/gmaps.min.js') }}" ></script>
    <!--page level js ends-->


@stop
