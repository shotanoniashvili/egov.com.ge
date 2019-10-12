@extends('layouts.default')

{{-- Page title --}}
@section('title')
    არქივი
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
                            <a href="{{ url()->to('/best-practice') }}">არქივი</a>
                        </li>
                    </ol>
                    <div class="float-right mt-1">
                        <i class="livicon icon3" data-name="doc-landscape" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> არქივი
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


{{-- Page content --}}
@section('content')
    <hr class="content-header-sep">
    <div class="container mb-5">
        <div class="welcome">
            <h3>არქივი</h3>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                @include('projects.filter-form')
            </div>
            <div class="col-12">
                <div class="row">
                    @forelse($projects as $project)
                        <div class="col-md-6 col-lg-4 col-12 my-2">
                            <!-- BEGIN FEATURED POST -->
                            <div class="featured-post-wide thumbnail">
                                <a href="{{ route('projects.show', $project->id) }}"><img src="{{ asset($project->picture) }}" class="img-fluid project-thumbnail" alt="{{ $project->title }}"></a>
                                <div class="featured-text relative-left">
                                    <h4 class="primary mt-1">
                                        <a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                                    </h4>
                                    <p class="project-content">{{ $project->getShortDescription() }}</p>

                                    <p class="additional-post-wrap">
                                        <span class="d-block">მუნიციპალიტეტი: {{ $project->municipality->name }}</span>
                                        <span class="d-block">თემატიკა: {{ $project->category->name }}</span>
                                        <span class="d-block">სტატუსი: {{ $project->getStatus() }}</span>
                                    </p>
                                    <hr>
                                    <p class="text-right">
                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary text-white">მეტის ნახვა</a>
                                    </p>
                                </div>
                                <!-- /.featured-text -->
                            </div>
                        </div>
                    @empty
                        <div class="col-sm-12">ატვირთული პრაქტიკა / ინიციატივა არ არსებობს</div>
                    @endforelse
                    <div class="col-sm-12">
                        <div class="mx-auto w-auto">
                            {{ $projects->appends(['years' => request()->years, 'categories' => request()->categories, 'municipalities' => request()->municipalities])->links() }}
                        </div>
                    </div>
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