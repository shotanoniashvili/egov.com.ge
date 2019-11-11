@extends('layouts.default')

{{-- Page title --}}
@section('title')
    შეფასება - {{ $project->title }}
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
                        <li>
                            <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                            <a href="#">შეფასება</a>
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
    <div class="container mt-5 mb-5">
        <div class="welcome">
            <h3>საუკეთესო პრაქტიკა / ინიციატივის შეფასება</h3>
        </div>
        <hr>
        <div class="row content mt-5">
            <!-- Business Deal Section Start -->
            <div class="col-sm-12 col-md-8">
                @include('notifications')
                <form action="{{ route('projects.evaluate', $project->id) }}" method="post">
                    @csrf
                    @foreach($project->category->rates->criterias as $criteria)
                        <div class="criteria-container mb-5">
                            <h3><strong>{{ $criteria->name }}</strong> <span class="text-muted small-1 d-block font-weight-normal">საერთო ქულის პროცენტი: <u>{{ $criteria->percent_in_total }}%</u></span></h3>
                            <hr>
                            @foreach($criteria->subCriterias as $subCriteria)
                                <div class="subcriteria-container pl-5 mt-2 border-bottom pb-3 mb-4">
                                    <div class="subcriteria-name"><h4>{{ $subCriteria->name }}</h4></div>
                                    @if($subCriteria->isNumberFormat)
                                        <div class="subcriteria-value mt-1">
                                            ქულა:
                                            <input name="criterias[{{ $criteria->id }}][{{ $subCriteria->id }}]" type="text" class="form-control d-inline-block w-auto" />
                                            <span class="text-muted small">მან: 0; მაქს: {{ $subCriteria->max_point }}</span>
                                        </div>
                                    @else
                                        <div class="subcriteria-value mt-1">
                                            <span class="mr-2">პასუხი:</span>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="criterias[{{ $criteria->id }}][{{ $subCriteria->id }}][yesno]" id="sub_yes{{$subCriteria->id}}" type="radio" value="1">
                                                <label class="form-check-label" for="sub_yes{{$subCriteria->id}}">კი</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" name="criterias[{{ $criteria->id }}][{{ $subCriteria->id }}][yesno]" id="sub_no{{$subCriteria->id}}" type="radio" value="0">
                                                <label class="form-check-label" for="sub_no{{$subCriteria->id}}">არა</label>
                                            </div>
                                            <span class="text-muted small d-block">კი: {{ $subCriteria->yes_point }} ქ.; არა: {{ $subCriteria->no_point }} ქ.</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="text-center">
                        <button class="btn btn-success">შეფასება</button>
                        <a href="{{ URL::to('my-account/to-evaluate') }}" class="btn btn-warning">უარყოფა</a>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class=" thumbnail featured-post-wide img">
                    @if($project->picture)
                        <img src="{{ asset($project->picture) }}" class="img-fluid" alt="{{ $project->title }}">
                    @endif
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
                        @if(count($project->documents) > 0)
                            <h3 class="comments">თანდართული დოკუმენტები/მასალები</h3><br />
                            <ul class="media-list project-files p-0 m-0">
                                @foreach($project->documents as $document)
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