@extends('layouts/default')

{{-- Page title --}}
@section('title')
    სიახლეები
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/news.css') }}">
    <link href="{{ asset('vendors/animate/animate.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/timeline.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />
    <link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet" />

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
                    <a href="#">სიახლეები</a>
                </li>
            </ol>
            <div class="float-right">
                <i class="livicon icon3" data-name="responsive-menu" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> სიახლეები
            </div>
        </div>
    </div>
        </div>
    </div>
@stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container news mt-5">
        <div class="welcome">
            <h3>სიახლეები</h3>
        </div>
        <hr />
        <form id="sortForm" action="" method="get">
            <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <label class="control-label d-inline-block" for="sortBy">დალაგება</label>
                    <select class="form-control d-inline-block w-auto" id="sortBy" name="sort_by">
                        <option value="date" {{ (!request()->sort_by || request()->sort_by == 'date') ? 'selected' : '' }}>დამატების თარიღის მიხედვით</option>
                        <option value="views" {{ request()->sort_by == 'views' ? 'selected' : '' }}>ნახვების მიხედვით</option>
                    </select>
                </div>
            </div>
        </form>

        <div class="row news">

            <div class="col-md-12">
                <div class="row">
                    @if( $news->count() != 0)

{{--                        <div class="text-left">--}}
{{--                            <div>--}}
{{--                                <h4><span class="heading_border bg-success">Hot News</span></h4>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        @foreach($news as $item)
{{--                            <div class="media my-2">--}}
{{--                                <div class="media-left">--}}
{{--                                    <a href="{{ route('news.show',$item->id) }}">--}}
{{--                                        <img class="media-object mr-3" src="{{ URL::to('/uploads/news/'.$item->image)  }}"--}}
{{--                                             alt="image">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <div class="media-body">--}}
{{--                                    <span class="text-danger">{!! date('d-m-Y', strtotime($item->created_at)) !!}</span>--}}
{{--                                    <a href="{{ route('news.show',$item->id) }}">--}}
{{--                                        <h5 class="media-heading ">{{ $item->title }}</h5>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col-md-6 col-lg-4 col-12 my-2">
                            <!-- BEGIN FEATURED POST -->
                            <div class="featured-post-wide thumbnail">
                                <a href="{{ route('news.show',$item->id) }}"><img src="{{ asset($item->image) }}" class="img-fluid project-thumbnail" alt="ელექტრონული პეტიციის სისტემის ამოქმედება"></a>
                                <div class="featured-text relative-left">
                                    <h4 class="primary mt-1">
                                        <a href="{{ route('news.show',$item->id) }}">{{ $item->title }}</a>
                                    </h4>
                                    <p class="news-content">
                                        <span class="d-block">{!! $item->getDate() !!}</span>
                                        <span class="d-block"><i class="fa fa-eye"></i> {!! $item->getViewCount() !!}</span>
                                    </p>

                                    <p class="additional-post-wrap">
                                        <span class="d-block">{!! $item->getDescription()  !!}</span>

                                    </p>
                                    <hr>
                                    <p class="text-right">
                                        <a href="{{ route('news.show',$item->id) }}" class="btn btn-nala text-white">მეტის ნახვა</a>
                                    </p>
                                </div>
                                <!-- /.featured-text -->
                            </div>
                    </div>
                        @endforeach
                    @endif
                </div>

            </div>


            </div>
            <!-- Tab-content End -->
        </div>
        <!-- //Tabbablw-line End -->
    </div>
    <!-- Tabbable_panel End -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page level js -->
    <!--tags-->
    <script src="{{ asset('vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('vendors/jquery_newsTicker/js/jquery.newsTicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/owl_carousel/js/owl.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/select2/js/select2.js') }}" type="text/javascript"></script>

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

        $('#sortBy').on('change', function () {
            $('#sortForm').submit();
        });

    </script>
    <!-- end of page level js -->

@stop
