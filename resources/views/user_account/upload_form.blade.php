@extends('user_account/layout')

@section('title')
    ჩემი პროფილი
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
                <h3 class="text-primary" id="title">პროექტის ატვირთვა</h3>
                <hr />
            </div>

        </div>
        <form id="projectForm" action="{{ route('my-account.upload') }}"
              method="POST" enctype="multipart/form-data" class="form-horizontal upload-project-form">
            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div id="rootwizard">
                <ul>
                    <li class="nav-item"><a href="#tab1" data-toggle="tab" class="nav-link">ინიციატივის შესახებ</a></li>
                    <li class="nav-item"><a href="#tab2" data-toggle="tab" class="nav-link ml-2">დოკუმენტები</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane " id="tab1">
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            <div class="row">
                                <label for="title" class="col-sm-12 control-label">პრაქტიკის/ინიციატივის სათაური *</label>
                                <div class="col-sm-12">
                                    <textarea id="title" name="title" class="form-control required">{{ old('title') }}</textarea>

                                    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('category_id', 'has-error') }}">
                            <div class="row">
                                <label for="category_id" class="col-sm-12 control-label">თემატიკა *</label>
                                <div class="col-sm-12">
                                    <select class="form-control required" title="აირჩეთ თემატიკა..." name="category_id"
                                            id="category_id">
                                        <option value=""></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($category->id == old('category_id')) selected="selected" @endif >{{ $category->name}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('category_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('picture', 'has-error') }}">
                            <div class="row">
                                <label for="picture" class="col-sm-12 control-label">სურათი</label>
                                <div class="col-sm-12">
                                    <input type="file" class="custom-file-input required" id="picture" name="picture">
                                    <label class="custom-file-label mx-3" for="picture">აირჩიეთ სურათი...</label>
                                </div>
                                <span class="help-block">{{ $errors->first('picture', '<span class="help-block">:message</span>') }}</span>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('short_description', 'has-error') }}">
                            <div class="row">
                                <label for="short_description" class="col-sm-12 control-label">პრაქტიკის/ინიციატივის მოკლე აღწერა *</label>
                                <div class="col-sm-12">
                                    <textarea id="short_description" name="short_description" class="form-control required">{{ old('short_description') }}</textarea>

                                    {!! $errors->first('short_description', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('municipality_id', 'has-error') }}">
                            <div class="row">
                                <label for="municipality_id" class="col-sm-12 control-label">მუნიციპალიტეტი *</label>
                                <div class="col-sm-12">
                                    <select class="form-control required" title="აირჩეთ მუნიციპალიტეტი..." name="municipality_id"
                                            id="municipality_id">
                                        <option value=""></option>
                                        @foreach($municipalities as $municipality)
                                            <option value="{{ $municipality->id }}"
                                                    @if($municipality->id == old('municipality_id')) selected="selected" @endif >{{ $municipality->name}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('municipality_id', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab2" disabled="disabled">
                        <div class="form-group {{ $errors->first('documents.*', 'has-error') }}">
                            <div class="row">
                                <div class="custom-file">
                                    <label for="documents" class="col-sm-12 control-label">თანდართული დოკუმენტები/მასალები</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="custom-file-input required" multiple id="documents" name="documents[]">
                                        <label class="custom-file-label px-3" for="documents">აირჩიეთ დოკუმენტები/მასალები...</label>
                                    </div>
                                    <span class="help-block">{{ $errors->first('documents.*', ':message') }}</span>
                                </div>
                                {{--<div class="file-list d-none">--}}
                                    {{--<div class="col-12">--}}
                                        {{----}}
                                    {{--</div>--}}
                                {{--</div>--}}
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
    <link rel="stylesheet" href="{{ asset('vendors/blueimp-file-upload/css/jquery.fileupload.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendors/blueimp-file-upload/css/jquery.fileupload-ui.css') }}"/>
    <!--end of page level css-->
@stop
@section('footer_scripts')
    <script src="{{ asset('vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('vendors/moment/js/moment.min.js') }}" ></script>
    <script src="{{ asset('vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"  type="text/javascript"></script>
    <script src="{{ asset('vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/bootstrapwizard/jquery.bootstrap.wizard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/tinymce/js/tinymce.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/uploadproject.js') }}"></script>
@stop
