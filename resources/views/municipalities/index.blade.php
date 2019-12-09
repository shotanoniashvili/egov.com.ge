@extends('layouts.default')

{{-- Page title --}}
@section('title')
    მუნიციპალიტეტები
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
                        <li>
                            <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                            <a href="{{ url()->to('/municipalities') }}">მუნიციპალიტეტები</a>
                        </li>
                    </ol>
                    <div class="float-right mt-1">
                        <i class="livicon icon3" data-name="doc-landscape" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> მუნიციპალიტეტები
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


{{-- Page content --}}
@section('content')
    <div class="container mb-5 mt-5">
        <div class="welcome">
            <h3>მუნიციპალიტეტები</h3>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 py-4 mb-5 primary text-center">
                <a class="abc-link" href="{{ url()->to('/municipalities') }}">ყველა</a>
                @foreach($abcArray as $abc)
                    <a class="abc-link {{ (request()->get('s') == $abc) ? 'active' : '' }}" href="{{ url()->to('/municipalities?s='.$abc) }}"> {{ $abc }}</a>
                @endforeach
            </div>
            <div class="col-12">
                <div class="row">
                    @forelse($municipalities as $municipality)
                        <div class="col-md-4 col-12 my-2">
                            <!-- BEGIN FEATURED POST -->
                            <div class="municipality-details text-center">
                                <a href="{{ route('municipalities.show', $municipality->id) }}">
                                    <img src="{{ asset($municipality->image) }}" class="municipality-image" alt="{{ $municipality->name }}"></a>
                                <div>
                                    <h4 class="primary mt-1">
                                        <a href="{{ route('municipalities.show', $municipality->id) }}">{{ $municipality->name }}</a>
                                    </h4>
                                    <hr>
                                    <a href="{{ route('municipalities.show', $municipality->id) }}" class="btn btn-nala text-white">პროექტების ნახვა</a>
                                </div>
                                <!-- /.featured-text -->
                            </div>
                        </div>
                    @empty
                        <div class="col-sm-12">მუნიციპალიტეტები არ არსებობს</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@stop