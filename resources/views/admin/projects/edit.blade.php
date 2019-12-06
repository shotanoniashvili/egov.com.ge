@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    პროექტის რედაქტირება
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css -->
    <link href="{{ asset('vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/pages/wizard.css') }}" rel="stylesheet">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>პროექტის რედაქტირება</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="#"> პროექტები</a></li>
            <li class="active">პროექტის რედაქტირება</li>
        </ol>
    </section>
    <section class="content pr-3 pl-3">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card ">
                    <div class="card-header bg-primary text-white">
                        <span class="float-left my-2">
                            <i class="livicon" data-name="project-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            პროექტის რედაქტირება
                        </span>
                    <!--<a href="{{ URL('admin/bulk_import_users') }}" class="float-right btn btn-success">
                            <i class="fa fa-plus fa-fw"></i>Bulk Import</a>-->

                    </div>
                    <div class="card-body">
                        <!--main content-->
                        <form id="projectForm" action="{{ route('admin.projects.edit', $project->id) }}"
                              method="POST" enctype="multipart/form-data" class="form-horizontal upload-project-form">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="_method" value="patch" />

                            <div id="rootwizard">
                                <ul role="tablist">
                                    <li class="nav-item"><a role="tab" href="#tab1" data-toggle="tab" class="nav-link">პროექტის შესახებ</a></li>
                                    <li class="nav-item"><a role="tab" href="#tab2" data-toggle="tab" class="nav-link ml-2">დოკუმენტები</a></li>
                                </ul>
                                <div class="tab-content col-sm-12 col-md-8 col-lg-6 offset-sm-0 offset-md-2 offset-lg-3">
                                    <div class="tab-pane" id="tab1">
                                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                                            <div class="row">
                                                <label for="title" class="col-sm-12 col-md-4 control-label">პროექტის სათაური *</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <textarea id="title" name="title" class="form-control required">{{ $project->title }}</textarea>

                                                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('category_id', 'has-error') }}">
                                            <div class="row">
                                                <label for="category_id" class="col-sm-12 col-md-4 control-label">თემატიკა *</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <select class="form-control required" title="აირჩეთ თემატიკა..." name="category_id"
                                                            id="category_id">
                                                        <option value=""></option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                    @if($category->id == $project->category_id) selected="selected" @endif >{{ $category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('picture', 'has-error') }}">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-12 offset-md-4 mb-3">
                                                    <img class="project-image" style="height: 256px" src="{{ asset($project->image) }}" />
                                                </div>
                                                <p class="text-warning offset-md-4 col-sm-12 col-md-8"><strong>აირჩიეთ სხვა სურათი თუ გსურთ არსებულის შეცვლა</strong></p>
                                                <label for="picture" class="col-sm-12 col-md-4 control-label">სურათი</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input type="file" class="custom-file-input required" id="picture" name="picture">
                                                    <label class="custom-file-label mx-3" for="picture">აირჩიეთ სურათი...</label>
                                                </div>
                                                <span class="help-block">{{ $errors->first('picture', '<span class="help-block">:message</span>') }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('short_description', 'has-error') }}">
                                            <div class="row">
                                                <label for="short_description" class="col-sm-12 col-md-12 control-label">პროექტის მოკლე აღწერა *</label>
                                                <div class="col-sm-12 col-md-12">
                                                    <textarea id="short_description" name="short_description" class="form-control required">{{ $project->short_description }}</textarea>

                                                    {!! $errors->first('short_description', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('municipality_id', 'has-error') }}">
                                            <div class="row">
                                                <label for="municipality_id" class="col-sm-12 col-md-4 control-label">მუნიციპალიტეტი *</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <select class="form-control required" title="აირჩეთ მუნიციპალიტეტი..." name="municipality_id"
                                                            id="municipality_id">
                                                        <option value=""></option>
                                                        @foreach($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}"
                                                                    @if($municipality->id == $project->municipality_id) selected="selected" @endif >{{ $municipality->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('municipality_id', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="checkbox col-md-8 col-sm-12 offset-md-4">
                                                    <label>
                                                        <input type="checkbox" name="is_best_practise" {{ $project->is_best_practise ? 'checked' : '' }} class="custom-checkbox"> დაემატოს როგორც საუკეთესო პრაქტიკა
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="checkbox col-md-8 col-sm-12 offset-md-4">
                                                    <label>
                                                        <input type="checkbox" name="is_archive" {{ $project->is_archive ? 'checked' : '' }} class="custom-checkbox toggle-date"> დაემატოს როგორც არქივი
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group date-field-container hide">
                                            <div class="row">
                                                <label for="date" class="col-sm-12 col-md-4 control-label">პროექტის განთავსების წელი *</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input id="date" name="date" class="form-control required datetimepicker year" value="{{ $project->date }}">

                                                    {!! $errors->first('date', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <label for="rating_points" class="col-sm-12 col-md-4 control-label">შეფასების ქულა *</label>
                                                <div class="col-sm-12 col-md-8">
                                                    <input id="rating_points" name="rating_points" class="form-control required" value="{{ $project->rating_points }}">

                                                    {!! $errors->first('rating_points', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2">
                                        <div class="form-group {{ $errors->first('documents.*', 'has-error') }}">
                                            <div class="row custom-file">
                                                <label class="col-sm-12 col-md-12">თანდართული დოკუმენტები/მასალები</label>
                                                <div class="col-sm-12 col-md-12 mb-3">
                                                    <ul class="media-list project-files p-0 m-0">
                                                        @foreach($project->documents as $document)
                                                            <li class="media mb-2" data-id="{{ $document->id }}">
                                                                <img class="project-file-icon" src="{{ $document->getIconSrc() }}" />
                                                                <a class="document-name" style="color: #3c8dbc !important" href="{{ asset($document->path) }}">{{$document->getTitle()}}</a>
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
                                                </div>
                                                <label for="documents" class="col-sm-12 col-md-12 control-label">თანდართული დოკუმენტები/მასალების ატვირთვა</label>
                                                <div class="col-sm-12 col-md-12">
                                                    <input type="file" class="custom-file-input required" multiple id="documents" name="documents[]">
                                                    <label class="custom-file-label px-3" for="documents">აირჩიეთ დოკუმენტები/მასალები...</label>
                                                </div>
                                                <span class="help-block">{{ $errors->first('documents.*', ':message') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard">
                                        <li class="previous"><a href="#">უკან</a></li>
                                        <li class="next"><a href="#">შემდეგი</a></li>
                                        <li class="next finish" style="display: none;"><a href="javascript:;">დასრულება</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        <!--row end-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="{{ asset('vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/tinymce/js/tinymce.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/editproject.js') }}"></script>

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