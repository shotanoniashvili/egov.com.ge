@extends('user_account/layout')

@section('title')
    ატვირთული პროექტები
@stop

@section('user_account_content')

    <div class="col-md-9 col-12">
        <!--main content-->
        <div class="position-center">
            <!-- Notifications -->
            <div id="notific">
                @include('notifications')
            </div>

            <div>
                <h3 class="text-primary" id="title">ატვირთული პროექტები</h3>
                <hr />
            </div>

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
                                <p class="project-content">{!! $project->getShortDescription() !!}</p>

                                <p class="additional-post-wrap">
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
            </div>
        </div>
    </div>

@stop