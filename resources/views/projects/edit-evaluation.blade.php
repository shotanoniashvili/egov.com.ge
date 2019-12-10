@extends('layouts.default')

{{-- Page title --}}
@section('title')
    შეფასების რედაქტირება - {{ $project->title }}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/blog.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/jquery-confirm/jquery-confirm.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/rangeslider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/toastr/css/toastr.css') }}">
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
                            <a href="{{ route('projects.rating', [$project->id, $expert->id]) }}">შეფასება</a>
                        </li>
                        <li>
                            <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                            <a href="#">რედაქტირება</a>
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
            <h3>{{ $project->title }} / შეფასების რედაქტირება ({{ $expert->fullname }})</h3>
            <span class="text-muted d-block">საერთო რეიტინგი: <span id="totalRating">{{ $project->rating_points }}</span></span>
            <span class="text-muted">{{ $expert->fullname }}ს რეიტინგი: <span id="expertRating">{{ $project->getRatingSumByExpert($expert->id) }}</span></span>
            @if($user->roles()->where('slug', 'admin')->count() > 0)
                <a class="ml-3 btn btn-danger btn-sm btn-remove-evalution" href="#"><i class="fa fa-eraser"></i> შეფასების წაშლა</a>
            @endif
        </div>
        <hr>
        <div class="row content mt-5">
            <!-- Business Deal Section Start -->
            <div class="col-sm-12 col-md-8">
                @include('notifications')
                @foreach($evaluations as $evaluation)
                    <div class="criteria-container mb-5">
                        <h3><strong>{{ $evaluation->criteria_name }}</strong></h3>
                        <hr>
                        @foreach($evaluation->subEvaluations as $subEvaluation)
                            <div class="subcriteria-container pl-5 mt-2 border-bottom pb-3 mb-4">
                                <div class="subcriteria-name"><h4>{{ $subEvaluation->criteria_name }}</h4></div>
                                @if($subEvaluation->criteria)
                                        @if($subEvaluation->criteria->isFreePoint)
                                            <div class="subcriteria-value mt-1">
                                                ქულა (0-დან 10-მდე):
                                                <input min="0" max="10" name="evaluations[{{ $subEvaluation->id }}]" value="{{ $subEvaluation->point }}" type="number" class="form-control d-inline-block w-auto" />
                                                <button class="btn btn-primary btn-edit-evaluation" data-id="{{ $subEvaluation->id }}">რედაქტირება</button>
                                            </div>
                                        @elseif($subEvaluation->criteria->isPercentable)
                                            <div class="subcriteria-value mt-1">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <span class="mr-2">პროცენტული შეფასება:</span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <input value="{{ (int)($subEvaluation->point * 10) }}" type="range" min="0" max="100" step="1" name="evaluations[{{ $subEvaluation->id }}]" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="number" max="100" min="1" class="range-field form-control" value="{{ (int)($subEvaluation->point * 10) }}" data-range-id="{{$subEvaluation->id}}" />
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button class="btn btn-primary btn-edit-evaluation" data-id="{{ $subEvaluation->id }}">რედაქტირება</button>
                                                        <span class="text-muted small d-block">პროცენტი: <span class="percent-point">{{ (int)($subEvaluation->point * 10) }}</span> (ყოველი 10% არის 1 ქულა)</span>
                                                    </div>
                                                </div>

                                            </div>
                                        @elseif($subEvaluation->criteria->isCustomPoint)
                                            <div class="subcriteria-value mt-1">
                                                <span class="mr-2">პასუხი:</span>
                                                @foreach($subEvaluation->criteria->customCriterias as $custom)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" name="evaluations[{{ $subEvaluation->id }}]" id="custom{{$subEvaluation->id}}" type="radio" value="{{$custom->id}}" {{ ($subEvaluation->evaluation == $custom->title) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="custom{{$subEvaluation->id}}">{{ $custom->title }} ({{ $custom->point }} ქ.)</label>
                                                    </div>
                                                @endforeach
                                                <button class="btn btn-primary btn-edit-evaluation" data-id="{{ $subEvaluation->id }}">რედაქტირება</button>
                                            </div>
                                        @endif
                                    @else
                                    <div class="subcriteria-value mt-1">
                                        ქულა:
                                        <input name="evaluations[{{ $subEvaluation->id }}]" type="number" value="{{ $subEvaluation->point }}" class="form-control d-inline-block w-auto" /><button class="btn btn-primary btn-edit-evaluation" data-id="{{ $subEvaluation->id }}">რედაქტირება</button>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                @endforeach
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
                                    <i class="livicon" data-name="clock" data-size="13" data-loop="true" data-c="#5bc0de" data-hc="#5bc0de"></i><a href="#"> {{$project->created_at->format('d-m-Y')}} </a>
                                </span>
                        </div>
                        <p class="text-justify">
                            {!! $project->short_description !!}
                        </p>
                        @if(count($project->documents) > 0)
                            <h5 class="comments">თანდართული დოკუმენტები/მასალები</h5><br />
                            <ul class="media-list project-files p-0 m-0">
                                @foreach($project->documents as $document)
                                    <li class="media" data-id="{{ $document->id }}">
                                        <img class="project-file-icon" src="{{ $document->getIconSrc() }}" />
                                        <a class="document-name" href="{{ asset($document->path) }}" title="{{$document->getTitle()}}">{{$document->getShortTitle()}}</a>
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
    <script type="text/javascript" src="{{ asset('js/frontend/rangeslider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/jquery-confirm/jquery-confirm.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/toastr/js/toastr.js') }}"></script>

    <script type="text/javascript">
        let $url_path = '{!! url('/') !!}';
        $('.btn-remove-evalution').on('click', function() {
            $.confirm({
                title: 'შეფასების წაშლა',
                content: 'ნამდვილად გსურთ შეფასების წაშლა?',
                buttons: {
                    confirm: {
                        text: 'წაშლა',
                        action: function() {
                            window.location.href = '{{ route('admin.projects.delete-evaluation', [$project->id, $expert->id]) }}';
                        }
                    },
                    cancel: {
                        text: 'უარყოფა'
                    }
                }
            });
        });

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

        $(function() {
            $('input[type="range"]').rangeslider({
                polyfill: false,

                // Callback function
                onSlide: function(position, value) {
                    $(this.$element).parent().parent().find('.percent-point').text(value);
                    $(this.$element).parent().parent().find('.range-field').val(value);
                }
            });

            $('.range-field').on('keyup', function() {
                let range = $(this).parent().parent().find('input[type="range"]');
                range.val($(this).val()).change();
            });

            $('.btn-edit-evaluation').on('click', function() {
                let id = $(this).data('id');

                let that = $(this);
                toggleLoading($(this));

                $.post('{{ route('admin.projects.edit-evaluation', [$project->id, $expert->id]) }}', {
                    evaluation: id,
                    point: $('input[name="evaluations['+id+']"]').val(),
                    _token: '{{ csrf_token() }}'
                }).done((response) => {
                    toastr.success('შეფასება წარმატებით დარედაქტირდა');

                    $('#totalRating').text(''+response.data.rating_points);
                    $('#expertRating').text(''+response.data.expert_points);
                }).fail((e) => {
                    toastr.error('დაფიქსირდა შეცდომა შეფასების რედაქტირების დროს');
                }).always(() => {
                    toggleLoading(that);
                });
            });

            function toggleLoading($el) {
                if($el.attr('disabled')) {
                    $el.text('რედაქტირება');
                    $el.removeAttr('disabled');
                } else {
                    $el.text('ტვირთება...');
                    $el.attr('disabled', 'disabled');
                }
            }
        });
    </script>
@stop