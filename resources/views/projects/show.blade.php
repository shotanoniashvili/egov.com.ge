@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ $project->title }}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
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
                        <li>
                            <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                            <a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                        </li>
                    </ol>
                    <div class="float-right mt-1">
                        <i class="livicon icon3" data-name="doc-landscape" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> {{ $project->title }}
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
        <div class="row content">
            <!-- Business Deal Section Start -->
            <div class="col-sm-8 col-md-8">
                @include('notifications')
                <h2 class="primary marl12 my-3 position-relative">
                    {{ $project->title }}
                    <div class="project-actions">
                        @if($user && $user->roles()->where('slug', 'admin')->count() > 0)
                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> რედაქტირება</a>
                        @endif
                        @if($user && $user->roles()->where('slug', 'expert')->count() > 0 && $user->categories()->where('id', $project->category_id)->count() > 0 && $project->getStatus() == 'შეფასების პროცესშია')
                            <a href="{{ route('projects.evaluate', $project->id) }}" class="btn btn-success"><i class="fa fa-check"></i> შეფასება</a>
                        @endif
                    </div>
                </h2>
                <div class=" thumbnail featured-post-wide img">
                    @if($project->picture)
                        <img src="{{ asset($project->picture) }}" class="project-image img-fluid" alt="{{ $project->title }}">
                @endif
                <!-- /.blog-detail-image -->
                    <div class="the-box no-border blog-detail-content">
                        <div class="additional-post-wrap">
                            <span class="additional-post">
                                    <i class="livicon" data-name="building" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i> {{ $project->municipality->name }}
                                </span>
                            <span class="additional-post">
                                    <i class="livicon" data-name="category" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i> {{ $project->category->name }}
                                </span>
                            <span class="additional-post">
                                    <i class="livicon" data-name="clock" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> {{$project->created_at->diffForHumans()}} </a>
                                </span>
                        </div>
                        <p class="text-justify">
                            {!! $project->short_description !!}
                        </p>
                        @if(count($projectDocuments) > 0)
                        <h3 class="comments">თანდართული დოკუმენტები/მასალები</h3><br />
                        <ul class="media-list project-files p-0 m-0">
                            @foreach($projectDocuments as $document)
                                <li class="media" data-id="{{ $document->id }}">
                                    <img class="project-file-icon" src="{{ $document->getIconSrc() }}" />
                                    <a class="document-name" href="{{ asset($document->path) }}">{{$document->getTitle()}}</a>
                                    <small class="text-danger ml-2"> {{ $document->getSize() }}</small>
                                    @if($user && $user->roles()->where('slug', 'admin')->count() > 0)
                                        <button data-toggle="modal" data-target="#renameDocument" class="btn btn-primary btn-rename-document mr-2 ml-3" title="სახელის შეცვლა"><i class="fa fa-edit"></i></button>
                                        <button data-toggle="modal" data-target="#confirmDelete" class="btn btn-danger btn-delete-document mr-2" title="დოკუმენტის წაშლა"><i class="fa fa-trash"></i></button>

                                        @if(!$document->is_visible)
                                            <a href="{{ route('admin.projects.toggle-document-visibility', $document->id) }}" class="btn btn-success mr-2" title="ყველა მომხმარებლისთვის გამოჩენა"><i class="fa fa-check"></i></a>
                                        @else
                                            <a href="{{ route('admin.projects.toggle-document-visibility', $document->id) }}" class="btn btn-warning mr-2" title="დამალვა მომხმარებლებისთვის"><i class="fa fa-ban"></i></a>
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <!-- /the.box .no-border -->
                <!-- Media left section start -->
            <!-- //Comment Section End -->
            </div>
            <!-- //Business Deal Section End -->
            <!-- /.col-sm-9 -->
            <!-- Recent Posts Section Start -->
            @if(count($project->municipality->getSimilar($project)) > 0)
            <div class="col-sm-4 col-md-4 col-full-width-left">
                <div class="the-box">
                    <h3 class="small-heading text-center">{{ $project->municipality->name }}ს პროექტები</h3>
                    @foreach($project->municipality->getSimilar($project) as $similarProject)
                        <div class="featured-post-wide mb-2">
                            <a href="{{ route('projects.show', $similarProject->id) }}"><img src="{{ asset($similarProject->picture) }}" class="img-fluid project-thumbnail" alt="{{ $similarProject->title }}"></a>
                            <div class="featured-text relative-left">
                                <h4 class="primary mt-1">
                                    <a href="{{ route('projects.show', $similarProject->id) }}">{{ $similarProject->title }}</a>
                                </h4>
                                <p class="project-content">{{ $similarProject->getShortDescription() }}</p>

                                <p class="additional-post-wrap">
                                    <span class="d-block">თემატიკა: {{ $similarProject->category->name }}</span>
                                </p>
                                <hr>
                                <div class="text-right">
                                    <a href="{{ route('projects.show', $similarProject->id) }}" class="btn btn-primary text-white">მეტის ნახვა</a>
                                </div>
                            </div>
                            <!-- /.featured-text -->
                        </div>
                        <hr />
                    @endforeach
                </div>
                <!-- /.the-box .bg-primary .no-border .text-center .no-margin -->
            </div>
            @endif
            <!-- //Recent Posts Section End -->
            <!-- /.col-sm-3 -->
        </div>
    </div>
    <!-- //container Section End -->
    <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">დოკუმენტის წაშლა</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    დარწმუნებული ხართ რომ გსურთ წაშალოთ მითითებული დოკუმენტი?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">უარყოფა</button>
                    <a type="button" class="btn btn-danger">დადასტურება</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="renameDocument" tabindex="-2" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">დოკუმენტის სახელის შეცვლა</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="renameForm">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="renameText">დოკუმენტის სახელი</label>
                            <input id="renameText" type="text" value="" name="name" class="form-control" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">უარყოფა</button>
                    <button type="submit" onclick="document.getElementById('renameForm').submit()" class="btn btn-primary">დადასტურება</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_scripts')
<script type="text/javascript">
    let $url_path = '{!! url('/') !!}';
    $('#confirmDelete').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let $recipient = button.parent().data('id');
        let modal = $(this);
        modal.find('.modal-footer a').prop("href",$url_path+"/admin/projects/documents/"+$recipient+"/delete");
    });

    $('#renameDocument').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let $recipient = button.parent().data('id');
        let currentName = button.parent().find('.document-name').text();
        let modal = $(this);

        modal.find('input[name="name"]').val(currentName);
        modal.find('#renameForm').prop("action", $url_path+"/admin/projects/documents/"+$recipient);
    });

    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
</script>
@stop