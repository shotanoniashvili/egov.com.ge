@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $news->title }}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/news.css') }}">
<link href="{{ asset('vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/blog.css') }}">
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
                <li class="d-none d-sm-block">
                    <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                    <a href="#">{{ $news->title }}</a>
                </li>
            </ol>
            <div class="float-right">
                <i class="livicon icon3" data-name="list-ul" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> {{ $news->title }}
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
        <div class="row">
            <!-- Jelly-o sesame Section Strat -->
            <div class="col-sm-12 col-md-12 " data-wow-duration="3.5s">
                <div class="col-md-12">
                    <div class="news_item_image thumbnail">
                        <label>
                            <h3 class="primary news_headings">{{ $news->title }}</h3>
                        </label>
                        @if($news->image)
                            <img src="{{ URL::to($news->image)  }}" class="img-fluid" alt="Image">
                        @endif
                        <div class="news_item_text_1">
                            <p>
                                {!! $news->content !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                </div>
            </div>

                <!-- Recent Post Section End -->

                </div>
                <!-- /.the-box .no-border -->
            </div>
            <!-- //Jelly-o sesame Section End -->
        </div>
    </div>
    
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('vendors/wow/js/wow.min.js') }}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function () {
            new WOW().init();
        });
    </script>

@stop
