@extends('layouts/default')

{{-- Page title --}}
@section('title')
    ძიების შედეგი
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/news.css') }}">
    <link href="{{ asset('vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />

    <link href="{{ asset('vendors/owl_carousel/css/owl.carousel.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/owl_carousel/css/owl.theme.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/owl_carousel/css/owl.transitions.css') }}" rel="stylesheet" type="text/css">


    <style>
        .news-body .media {
            padding-bottom: 10px;
            border-bottom: 1px solid #ececec;
        }

        .news-body .media-object {
            height: 95px;
            width: 95px;
        }

        .lifestyle img {
            max-height: 100%;
            max-width: 100%;
        }



        .newsticker {
            height: 350px !important;
        }

        #carousel img {
            height: 150px;
            width: 100%;
        }

        .owl-pagination {
            display: none;
        }

        .slider-content {
            height: 65px;
            overflow: hidden;
        }

        .height_180 {
            height: 180px;
            width: 100%;
        }

        .sports-content {
            height: 120px;
            overflow: hidden;
        }

        .sports-height {
            height: 200px;
            overflow: hidden;
        }

        .mt-20 {
            margin-top: 20px;
        }

        p a {
            color: #418bca !important;
        }

        .tabbable-line > .nav-tabs > li{
            background-color: transparent !important;
        }

       .news .tabbable-line > .nav-tabs .nav-link.active {
            border-bottom: 4px solid #f3565d !important;
        }

    </style>
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
                            <a href="#">ძიება</a>
                        </li>
                    </ol>
                    <div class="float-right mt-1">
                        <i class="livicon icon3" data-name="search" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> ძიება
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container news mt-4">
        <div class="row news">
            <div class="col-md-8">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="font-md">საძიებო სიტყვა: <span class="font-weight-bold">{{ request()->keyword }}</span></div>
                        <div class="font-md">ნაპოვნია <span class="font-weight-bold">{{ count($results) }}</span> მონაცემი</div>
                    </div>
                    @forelse($results as $item)
                        <div class="col-sm-12 search-body py-3">
                            <div class="row my-2">
                                <div class="result-image col-sm-12 col-md-2">
                                    <a href="{{ $item->getLink() }}">
                                        <img class="thumbnail mr-3" src="{{ asset($item->getImage()) }}" alt="image">
                                    </a>
                                </div>
                                <div class="result-text col-sm-12 col-md-10">
                                    <a href="{{ $item->getLink() }}">
                                        <h5 class="media-heading">{{ $item->getTitle() }} <span class="text-muted small">({{ $item->getModelName() }})</span></h5>
                                    </a>
                                    <div class="text-muted small">{!! $item->getDate() !== '' ? '<i class="fa fa-calendar-alt"></i> '.$item->getDate() : '' !!} </div>
                                    <p class="result-description">{{ $item->getDescription() }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        მონაცემები ვერ მოიძებნა
                    @endforelse
                    <div class="col-sm-12 mt-4">{{ $results->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page level js -->
    <!--tags-->
    <script src="{{ asset('vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('vendors/jquery_newsTicker/js/jquery.newsTicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}" type="text/javascript"></script>
    <script>

        $('.newsticker').newsTicker({
            direction: 'down',
            row_height: 85,
            max_rows: 3,
            duration: 2000
        });
        var owl = $('#carousel');
        owl.owlCarousel({
            autoPlay: 2000, //Set AutoPlay to 3 seconds
            items: 1,
            loop: true,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3],

        });


    </script>
    <!-- end of page level js -->

@stop
