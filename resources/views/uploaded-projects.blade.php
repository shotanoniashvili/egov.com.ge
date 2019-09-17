@extends('layouts.default')

{{-- Page title --}}
@section('title')
    User Account
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/iCheck/css/minimal/blue.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/css/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/css/select2-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/frontend/user_account.css') }}">

@stop

{{-- Page content --}}
@section('content')
    <hr class="content-header-sep">
    <div class="container">
        <div class="welcome">
            <h3>My Account</h3>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12 mb-3">
                <a class="btn btn-primary" href="#">ატვირთული პროექტები</a>
                <a class="btn btn-success" href="#">პროექტის ატვირთვა</a>
            </div>
            <div class="col-lg-10 col-12">
                <!--main content-->
                <div class="position-center">
                    <!-- Notifications -->
                    <div id="notific">
                        @include('notifications')
                    </div>

                    <div>
                        <h3 class="text-primary" id="title">Personal Information</h3>
                    </div>
                    {!! Form::model($user, ['url' => URL::to('my-account'), 'method' => 'put', 'class' => 'form-horizontal','enctype'=>"multipart/form-data"]) !!}

                    {{ csrf_field() }}
                </div>
                <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                    <div class="row">
                        <div class="col-lg-2 col-12">
                            <label class="control-label">
                                First Name:
                                <span class='require'>*</span>
                            </label>
                        </div>
                        <div class="col-lg-10 col-12">
                            <div class="input-group input-group-append">
                                    <span class="input-group-text">
                        <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                                    </span>
                                <input type="text" placeholder=" " name="first_name" id="first_name"
                                       class="form-control" value="{!! old('first_name',$user->first_name) !!}">
                            </div>
                            <span class="help-block">{{ $errors->first('first_name', ':message') }}</span>
                        </div>

                    </div>
                </div>

                <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                    <div class="row">
                        <div class="col-lg-2 col-12">
                            <label class="control-label">
                                Last Name:
                                <span class='require'>*</span>
                            </label>
                        </div>


                        <div class="col-lg-10 col-12">
                            <div class="input-group input-group-append">
                                            <span class="input-group-text">
                        <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                                            </span>
                                <input type="text" placeholder=" " name="last_name" id="last_name"
                                       class="form-control"
                                       value="{!! old('last_name',$user->last_name) !!}"></div>
                            <span class="help-block">{{ $errors->first('last_name', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                    <div class="row">
                        <div class="col-lg-2 col-12">
                            <label class="control-label">
                                Email:
                                <span class='require'>*</span>
                            </label>
                        </div>
                        <div class="col-lg-10 col-12">
                            <div class="input-group input-group-append">
                                                                <span class="input-group-text">
                        <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                                                                </span>
                                <input type="text" placeholder=" " id="email" name="email" class="form-control"
                                       value="{!! old('email',$user->email) !!}"></div>
                            <span class="help-block">{{ $errors->first('email', ':message') }}</span>
                        </div>

                    </div>
                </div>

                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                    <p class="text-warning col-md-offset-2"><strong>If you don't want to change password... please leave them empty</strong></p>
                    <div class="row">
                        <div class="col-lg-2 col-12">
                            <label class="control-label">
                                Password:
                                <span class='require'>*</span>
                            </label>
                        </div>

                        <div class="col-lg-10 col-12">
                            <div class="input-group input-group-append">
                                            <span class="input-group-text">
                        <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                                            </span>
                                <input type="password" name="password" placeholder=" " id="pwd" class="form-control"></div>
                            <span class="help-block">{{ $errors->first('password', ':message') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                    <div class="row">
                        <label class="col-lg-2  col-12 control-label">
                            Confirm Password:
                            <span class='require'>*</span>
                        </label>
                        <div class="col-lg-10 col-12">
                            <div class="input-group input-group-addon">
                                            <span class="input-group-text">
                        <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#418bca" data-hc="#418bca"></i>
                                            </span>
                                <input type="password" name="password_confirm" placeholder=" " id="cpwd" class="form-control"></div>
                            <span class="help-block">{{ $errors->first('password_confirm', ':message') }}</span>
                        </div>
                    </div>
                </div>


                <div class="form-group  {{ $errors->first('bio', 'has-error') }}">
                    <div class="row">
                        <div class="col-lg-2 col-12">
                            <label for="" class="control-label">Bio <small>(brief intro):</small></label>
                        </div>

                        <div class="col-lg-10 col-12">
                                            <textarea name="bio" id="bio" class="form-control resize_vertical"
                                                      rows="4">{!! old('bio', $user->bio) !!}</textarea>
                        </div>
                        {!! $errors->first('bio', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>


                <div>
                    <h3 class="text-primary" id="title">Contact: </h3>
                </div>

                <div class="form-group {{ $errors->first('address', 'has-error') }}">
                    <div class="row">

                        <div class="col-lg-2 col-12">
                            <label class="control-label">
                                Address:
                            </label>
                        </div>
                        <div class="col-lg-10 col-12">
                                        <textarea rows="5" cols="30" class="form-control resize_vertical" id="add1"
                                                  name="address">{!! old('address',$user->address) !!}</textarea>
                        </div>
                        <span class="help-block">{{ $errors->first('address', ':message') }}</span>
                    </div>
                </div>

                <div class="form-group {{ $errors->first('mobiles', 'has-error') }}">
                    <div class="row">

                        <div class="col-lg-2 col-12">
                            <label class="control-label" for="mobiles">
                                მობილური:
                            </label>
                        </div>
                        <div class="col-lg-10 col-12">
                            <input type="text" name="mobiles[]" class="form-control" id="mobiles" />
                        </div>
                        <span class="help-block">{{ $errors->first('mobiles', ':message') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-12 ml-auto">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>

                {!!  Form::close()  !!}
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')

    <script type="text/javascript" src="{{ asset('vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/iCheck/js/icheck.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/select2/js/select2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/frontend/user_account.js') }}"></script>

@stop
