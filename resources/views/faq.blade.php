@extends('layouts/default')

{{-- Page title --}}
@section('title')
    კითხვა-პასუხი
    @parent
    @stop

    {{-- page level styles --}}
    @section('header_styles')
            <!--start of page level css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/faq.css') }}">
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
                <li class="hidden-xs">
                    <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                    <a href="#">კითხვა-პასუხი</a>
                </li>
            </ol>
            <div class="float-right mt-1">
                <i class="livicon icon3" data-name="question" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> კითხვა-პასუხი
            </div>
        </div>
    </div>
        </div>
    </div>
    @stop


    {{-- Page content --}}
    @section('content')
            <!-- Container Section Start -->
    <div class="container mt-5">
        <div class="welcome">
            <h3>კითხვა-პასუხი</h3>
        </div>
        <hr />
        <div class="row my-3">
            <div class="col-md-12 col-12 col-lg-12 col-sm-12">
{{--                <div class="control-bar sandbox-control-bar mt10">--}}
{{--                    <span class="btn btn-primary mr10 mb10 filter active" data-filter="all">All</span>--}}
{{--                    <span class="btn btn-primary mr10 mb10 filter" data-filter=".category-1">HTML</span>--}}
{{--                    <span class="btn btn-primary mr10 mb10 filter" data-filter=".category-2">PHP</span>--}}
{{--                    <span class="btn btn-primary mr10 mb10 filter" data-filter=".category-3">JQUERY</span>--}}
{{--                </div>--}}
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="card-group card-accordion faq-accordion">
                            <div id="faq" class="w-100">
                                @foreach(App\Models\Faq::all() as $key => $faq)
                                    <div class="mix category-1 card mb-2 w-100" data-value="{{ $faq->id }}">
                                        <div class="card-header" id="headingOne">
                                            <h4 class="card-title">
                                                <a  href="#question{{ $faq->id }}" data-toggle="collapse" data-target="#question{{$faq->id}}" aria-expanded="true" aria-controls="question1">
                                                    <strong class="c-gray-light">{{ $key+1 }}.</strong>
                                                    {{ $faq->question }}
                                                    <span class="float-right">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="question{{ $faq->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#faq">

                                            <div class="card-body">
                                                {!! $faq->answer !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('js/frontend/faq.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.mixitup.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendors/mixitup/mixitup.js') }}"></script>
@stop
