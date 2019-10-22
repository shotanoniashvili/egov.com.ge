@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    მომხმარებლის რედაქტირება
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
        <h1>მომხმარებლების რედაქტირება</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="#"> მომხმარებლები</a></li>
            <li class="active">მომხმარებლის რედაქტირება</li>
        </ol>
    </section>
    <section class="content pr-3 pl-3">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12 my-3">
                <div class="card ">
                    <div class="card-header bg-primary text-white">
                        <span class="float-left my-2">
                            <i class="livicon" data-name="user-add" data-size="18" data-c="#fff" data-hc="#fff" data-loop="true"></i>
                            მომხმარებლის რედაქტირება
                        </span>
                    <!--<a href="{{ URL('admin/bulk_import_users') }}" class="float-right btn btn-success">
                            <i class="fa fa-plus fa-fw"></i>Bulk Import</a>-->

                    </div>
                    <div class="card-body">
                        <!--main content-->
                        <form id="commentForm" action="{{ route('admin.users.update', $targetUser->id) }}"
                              method="POST" enctype="multipart/form-data" class="form-horizontal">
                            <!-- CSRF Token -->
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="_method" value="patch" />

                            <div id="rootwizard">
                                <ul>
                                    <li class="nav-item"><a href="#tab1" data-toggle="tab" class="nav-link">პროფილი</a></li>
                                    <!--<li class="nav-item"><a href="#tab2" data-toggle="tab" class="nav-link ml-2">Bio</a></li>-->
                                    <!--<li class="nav-item"><a href="#tab3" data-toggle="tab" class="nav-link ml-2">Address</a></li>-->
                                    <li class="nav-item"><a href="#tab4" data-toggle="tab" class="nav-link ml-2">როლები</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane " id="tab1">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                            <div class="row">
                                                <label for="first_name" class="col-sm-2 control-label">სახელი *</label>
                                                <div class="col-sm-10">
                                                    <input id="first_name" name="first_name" type="text"
                                                           placeholder="სახელი" class="form-control required"
                                                           value="{!! $targetUser->first_name !!}"/>

                                                    {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                            <div class="row">
                                                <label for="last_name" class="col-sm-2 control-label">გვარი *</label>
                                                <div class="col-sm-10">
                                                    <input id="last_name" name="last_name" type="text" placeholder="გვარი"
                                                           class="form-control required" value="{!! $targetUser->last_name !!}"/>

                                                    {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                            <div class="row">
                                                <label for="email" class="col-sm-2 control-label">ელ-ფოსტა *</label>
                                                <div class="col-sm-10">
                                                    <input id="email" name="email" placeholder="ელ-ფოსტა" type="text"
                                                           class="form-control required email" value="{!! $targetUser->email !!}"/>
                                                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <p class="text-warning col-md-offset-2"><strong>თუ არ გსურთ პაროლის შეცვლა, დატოვეთ ცარიელი</strong></p>
                                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                            <div class="row">
                                                <label for="password" class="col-sm-2 control-label">პაროლი *</label>
                                                <div class="col-sm-10">
                                                    <input id="password" name="password" type="password" placeholder="პაროლი"
                                                           class="form-control" value="{!! old('password') !!}"/>
                                                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                            <div class="row">
                                                <label for="password_confirm" class="col-sm-2 control-label">დაადასტურეთ პაროლი *</label>
                                                <div class="col-sm-10">
                                                    <input id="password_confirm" name="password_confirm" type="password"
                                                           placeholder="დაადასტურეთ პაროლი " class="form-control"/>
                                                    {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--<div class="tab-pane" id="tab2" disabled="disabled">
                                        <h2 class="hidden">&nbsp;</h2>
                                        <div class="form-group  {{ $errors->first('dob', 'has-error') }}">
                                            <div class="row">
                                                <label for="dob" class="col-sm-2 control-label">Date of Birth</label>
                                                <div class="col-sm-10">
                                                    <input id="dob" name="dob" type="text" class="form-control"
                                                           data-date-format="YYYY-MM-DD"
                                                           placeholder="yyyy-mm-dd"/>
                                                </div>
                                                <span class="help-block">{{ $errors->first('dob', ':message') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->first('pic_file', 'has-error') }}">
                                            <div class="row">
                                            <label class="col-sm-2 control-label">Profile picture</label>
                                            <div class="col-sm-10">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                                                        <img src="http://placehold.it/200x200" alt="profile pic">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                                    <div>
                                                    </div>
                                <span class="btn btn-light btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input id="pic" name="pic_file" type="file" class="form-control"/>
                                </span>
                                                        <a href="#" class="btn btn-danger fileinput-exists"
                                                           data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>
                                                <span class="help-block">{{ $errors->first('pic_file', ':message') }}</span>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <div class="row">
                                            <label for="bio" class="col-sm-2 control-label">Bio <small>(brief intro) </small></label>
                                            <div class="col-sm-10">
                        <textarea name="bio" id="bio" class="form-control resize_vertical"
                                  rows="4">{!! old('bio') !!}</textarea>
                                            </div>
                                            {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
                                        </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab3" disabled="disabled">
                                        <div class="form-group {{ $errors->first('gender', 'has-error') }}">
                                            <div class="row">
                                            <label for="email" class="col-sm-2 control-label">Gender </label>
                                            <div class="col-sm-10">
                                                <select class="form-control" title="Select Gender..." name="gender">
                                                    <option value="">Select</option>
                                                    <option value="male"
                                                            @if(old('gender') === 'male') selected="selected" @endif >Male
                                                    </option>
                                                    <option value="female"
                                                            @if(old('gender') === 'female') selected="selected" @endif >
                                                        Female
                                                    </option>
                                                    <option value="other"
                                                            @if(old('gender') === 'other') selected="selected" @endif >Other
                                                    </option>

                                                </select>
                                            </div>
                                            <span class="help-block">{{ $errors->first('gender', ':message') }}</span>
                                        </div>
                                        </div>

                                        <div class="form-group {{ $errors->first('country', 'has-error') }}">
                                            <div class="row">
                                            <label for="country" class="col-sm-2 control-label">Country</label>
                                            <div class="col-sm-10">
                                                {!! Form::select('country', $countries, null,['class' => 'form-control select2', 'id' => 'countries']) !!}
                                        </div>
                                        <span class="help-block">{{ $errors->first('country', ':message') }}</span>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                            <label for="state" class="col-sm-2 control-label">State</label>
                                            <div class="col-sm-10">
                                                <input id="state" name="user_state" type="text" class="form-control"
                                                       value="{!! old('user_state') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('user_state', ':message') }}</span>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                            <label for="city" class="col-sm-2 control-label">City</label>
                                            <div class="col-sm-10">
                                                <input id="city" name="city" type="text" class="form-control"
                                                       value="{!! old('city') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('city', ':message') }}</span>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                            <label for="address" class="col-sm-2 control-label">Address</label>
                                            <div class="col-sm-10">
                                                <input id="address" name="address" type="text" class="form-control"
                                                       value="{!! old('address') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                            <label for="postal" class="col-sm-2 control-label">Postal/zip</label>
                                            <div class="col-sm-10">
                                                <input id="postal" name="postal" type="text" class="form-control"
                                                       value="{!! old('postal') !!}"/>
                                            </div>
                                            <span class="help-block">{{ $errors->first('postal', ':message') }}</span>
                                        </div>
                                    </div>
                                    </div>
                                    -->
                                    <div class="tab-pane" id="tab4" disabled="disabled">
                                        <!--<p class="text-danger"><strong>Be careful with group selection, if you give admin access.. they can access admin section</strong></p>-->

                                        <div class="form-group required">
                                            <div class="row">
                                                <label for="group" class="col-sm-2 control-label">მომხმარებლის როლი *</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control required" title="აირჩეთ როლი..." name="group"
                                                            id="group">
                                                        <option value="">აირჩიეთ</option>
                                                        @foreach($groups as $group)
                                                            <option value="{{ $group->id }}"
                                                                    @if($targetUser->getRoles()->where('id', $group->id)->count() > 0) selected="selected" @endif >{{ $group->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('group', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            <span class="help-block">{{ $errors->first('group', ':message') }}</span>
                                        </div>

                                        <div class="form-group project-category-container {{ $targetUser->getRoles()->where('name', 'ექსპერტი')->count() > 0 ? '' : 'hide' }}">
                                            <div class="row">
                                                <label for="project_category_ids" class="col-sm-2 control-label">თემატიკა / კატეგორია *</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select2" multiple title="აირჩეთ თემატიკა / კატეგორია..." name="project_category_ids[]"
                                                            id="project_category_ids">
                                                        @foreach($projectCategories as $projectCategory)
                                                            <option value="{{ $projectCategory->id }}"
                                                                    @if($targetUser->categories()->where('id', $projectCategory->id)->count() > 0) selected="selected" @endif >{{ $projectCategory->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('project_category_ids', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            <span class="help-block">{{ $errors->first('project_category_ids', ':message') }}</span>
                                        </div>

                                        <div class="form-group municipality-container {{ $targetUser->getRoles()->where('name', 'მუნიციპალიტეტის თანამშრომელი')->count() > 0 ? '' : 'hide' }}">
                                            <div class="row">
                                                <label for="municipality_ids" class="col-sm-2 control-label">მუნიციპალიტეტები *</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control select2" multiple title="აირჩეთ მუნიციპალიტეტები..." name="municipality_ids[]"
                                                            id="municipality_ids">
                                                        @foreach($municipalities as $municipality)
                                                            <option value="{{ $municipality->id }}"
                                                                    @if($targetUser->municipalities()->where('id', $municipality->id)->count() > 0) selected="selected" @endif >{{ $municipality->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('municipality_ids', '<span class="help-block">:message</span>') !!}
                                                </div>
                                            </div>
                                            <span class="help-block">{{ $errors->first('municipality_ids', ':message') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label for="activate" class="col-sm-2 control-label"> მომხმარებლის სტატუსის აქტივაცია *</label>
                                                <div class="col-sm-10">
                                                    <input id="activate" name="activate" type="checkbox"
                                                           class="pos-rel p-l-30 custom-checkbox"
                                                           value="1" @if($isActive) checked="checked" @endif >
                                                    <span>მონიშნეთ თუ გსურთ მომხმარებლის სტატუსი ავტომატურად გახდეს აქტიური</span></div>

                                            </div>
                                        </div>
                                    </div>
                                    <ul class="pager wizard">
                                        <li class="previous"><a href="#">უკან</a></li>
                                        <li class="next"><a href="#">შემდეგი</a></li>
                                        <li class="next finish" style="display:none;"><a href="javascript:;">დასრულება</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
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
    <script src="{{ asset('js/pages/edituser.js') }}"></script>
    <script>
        function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{ asset('img/countries_flags') }}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );

            return $state;

        }
        $(".select2").select2({
            theme:"bootstrap"
        });


    </script>
@stop
