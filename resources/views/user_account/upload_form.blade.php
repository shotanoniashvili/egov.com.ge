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
                    <li class="nav-item"><a href="#tab3" data-toggle="tab" class="nav-link ml-2">ავტორი</a></li>
                    <li class="nav-item"><a href="#tab4" data-toggle="tab" class="nav-link ml-2">საკონტაქტო ინფორმაცია</a></li>
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

                        <div class="form-group {{ $errors->first('detailed_description', 'has-error') }}">
                            <div class="row">
                                <label for="detailed_description" class="col-sm-12 control-label">პრაქტიკის/ინიციატივის დეტალური აღწერა *</label>
                                <div class="col-sm-12">
                                    <textarea id="detailed_description" name="detailed_description" class="form-control required">{{ old('detailed_description') }}</textarea>

                                    {!! $errors->first('detailed_description', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('goal', 'has-error') }}">
                            <div class="row">
                                <label for="goal" class="col-sm-12 control-label">მიღწეული შედეგი *</label>
                                <div class="col-sm-12">
                                    <textarea id="goal" name="goal" class="form-control required">{{ old('goal') }}</textarea>

                                    {!! $errors->first('goal', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('experience', 'has-error') }}">
                            <div class="row">
                                <label for="experience" class="col-sm-12 control-label">მიღებული გამოცდილება და გაკეთებული დასკვნები *</label>
                                <div class="col-sm-12">
                                    <textarea id="experience" name="experience" class="form-control required">{{ old('experience') }}</textarea>

                                    {!! $errors->first('experience', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('council_contribution', 'has-error') }}">
                            <div class="row">
                                <label for="council_contribution" class="col-sm-12 control-label">საკრებულოს როლი *</label>
                                <div class="col-sm-12">
                                    <textarea id="council_contribution" name="council_contribution" class="form-control required">{{ old('council_contribution') }}</textarea>

                                    {!! $errors->first('council_contribution', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('future_plans', 'has-error') }}">
                            <div class="row">
                                <label for="future_plans" class="col-sm-12 control-label">სამომავლო გეგმები *</label>
                                <div class="col-sm-12">
                                    <textarea id="future_plans" name="future_plans" class="form-control required">{{ old('future_plans') }}</textarea>

                                    {!! $errors->first('future_plans', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab2" disabled="disabled">
                        <div class="form-group {{ $errors->first('documents', 'has-error') }}">
                            <div class="row">
                                <div class="custom-file">
                                    <label for="documents" class="col-sm-12 control-label">თანდართული დოკუმენტები/მასალები</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="custom-file-input required" id="documents" name="documents[]">
                                        <label class="custom-file-label" for="documents">აირჩიეთ დოკუმენტები/მასალები...</label>
                                    </div>
                                    <span class="help-block">{{ $errors->first('documents', ':message') }}</span>
                                </div>
                                {{--<div class="file-list d-none">--}}
                                    {{--<div class="col-12">--}}
                                        {{----}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" disabled="disabled">
                        <div class="form-group {{ $errors->first('author.firstname', 'has-error') }}">
                            <div class="row">
                                <label for="firstname" class="col-sm-12 control-label">სახელი </label>
                                <div class="col-sm-12">
                                    <input type="text" id="firstname" name="author[firstname]" value="{{ old('author.firstname') }}" class="form-control required">

                                    {!! $errors->first('author.firstname', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('author.lastname', 'has-error') }}">
                            <div class="row">
                                <label for="lastname" class="col-sm-12 control-label">გვარი </label>
                                <div class="col-sm-12">
                                    <input type="text" id="lastname" name="author[lastname]" value="{{ old('author.lastname') }}" class="form-control required">

                                    {!! $errors->first('author.lastname', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('author.mobiles', 'has-error') }}">
                            <div class="row">
                                <label for="mobiles" class="col-sm-12 control-label">მობილური(ები) </label>
                                <div class="col-sm-12">
                                    <div class="mobile-form-groups" data-type="author">
                                        <div class="input-group mb-3">
                                            <input type="text" id="mobiles" name="author[mobiles][]" value="{{ (is_array(old('author.mobiles')) && count(old('author.mobiles')) > 0) ? old('author.mobiles')[0] : '' }}" class="form-control required">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-add-mobile"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    {!! $errors->first('author.mobiles', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('author.email', 'has-error') }}">
                            <div class="row">
                                <label for="email" class="col-sm-12 control-label">ელ-ფოსტა </label>
                                <div class="col-sm-12">
                                    <input id="email" name="author[email]" type="email" value="{{ old('author.email') }}" class="form-control required email">

                                    {!! $errors->first('author.email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('author.about', 'has-error') }}">
                            <div class="row">
                                <label for="about" class="col-sm-12 control-label">ავტორის შესახებ </label>
                                <div class="col-sm-12">
                                    <textarea id="about" name="author[about]" class="form-control required">
                                         {{ old('author.about') }}
                                    </textarea>

                                    {!! $errors->first('author.about', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4" disabled="disabled">
                        <!--<p class="text-danger"><strong>Be careful with group selection, if you give admin access.. they can access admin section</strong></p>-->

                        <div class="form-group {{ $errors->first('contact_info.firstname', 'has-error') }}">
                            <div class="row">
                                <label for="contact_info_firstname" class="col-sm-12 control-label">სახელი </label>
                                <div class="col-sm-12">
                                    <input type="text" id="contact_info_firstname" name="contact_info[firstname]" value="{{ old('contact_info.firstname') }}" class="form-control required">

                                    {!! $errors->first('contact_info.firstname', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('contact_info.lastname', 'has-error') }}">
                            <div class="row">
                                <label for="contact_info_lastname" class="col-sm-12 control-label">გვარი </label>
                                <div class="col-sm-12">
                                    <input type="text" id="contact_info_lastname" name="contact_info[lastname]" value="{{ old('contact_info.lastname') }}" class="form-control required">

                                    {!! $errors->first('contact_info.lastname', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('contact_info.mobiles', 'has-error') }}">
                            <div class="row">
                                <label for="contact_info_mobiles" class="col-sm-12 control-label">მობილური(ები) </label>
                                <div class="col-sm-12">
                                    <div class="mobile-form-groups" data-type="contact_info">
                                        <div class="input-group mb-3">
                                            <input type="text" id="contact_info_mobiles" name="contact_info[mobiles][]" value="{{ (is_array(old('contact_info.mobiles')) && count(old('contact_info.mobiles')) > 0) ? old('contact_info.mobiles')[0] : '' }}" class="form-control required">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-add-mobile"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    {!! $errors->first('contact_info.mobiles', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('contact_info.email', 'has-error') }}">
                            <div class="row">
                                <label for="contact_info_email" class="col-sm-12 control-label">ელ-ფოსტა </label>
                                <div class="col-sm-12">
                                    <input id="contact_info_email" name="contact_info[email]" type="email" value="{{ old('contact_info.email') }}" class="form-control required email">

                                    {!! $errors->first('contact_info.email', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('contact_info.about', 'has-error') }}">
                            <div class="row">
                                <label for="contact_info_about" class="col-sm-12 control-label">საკონტაქტო პირის შესახებ </label>
                                <div class="col-sm-12">
                                    <textarea id="contact_info_about" name="contact_info[about]" class="form-control required">
                                         {{ old('contact_info.about') }}
                                    </textarea>

                                    {!! $errors->first('contact_info.about', '<span class="help-block">:message</span>') !!}
                                </div>
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
    <script src="{{ asset('js/pages/uploadproject.js') }}"></script>
    <script>
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{ asset('img/countries_flags') }}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );

            return $state;

        }
        $("#countries").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "select a country",
            theme:"bootstrap"
        });


    </script>
@stop
