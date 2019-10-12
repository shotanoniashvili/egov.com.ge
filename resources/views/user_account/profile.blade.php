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
                <h3 class="text-primary" id="title">პროფილი</h3>
                <hr />
            </div>
            {!! Form::model($user, ['url' => URL::to('my-account'), 'method' => 'put', 'class' => 'form-horizontal','enctype'=>"multipart/form-data"]) !!}

            {{ csrf_field() }}
        </div>
        <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
            <div class="row">
                <div class="col-lg-2 col-12">
                    <label class="control-label">
                        სახელი:
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
                        გვარი:
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
                        ელ-ფოსტა:
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
            <p class="text-warning col-md-offset-2"><strong>თუ არ გსურთ პაროლის შეცვლა, დატოვეთ ცარიელი</strong></p>
            <div class="row">
                <div class="col-lg-2 col-12">
                    <label class="control-label">
                        პაროლი:
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
                    გაიმეორეთ პაროლი:
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

        <div class="form-group">
            <div class="col-lg-10 col-12 ml-auto">
                <button class="btn btn-primary" type="submit">შენახვა</button>
            </div>
        </div>

        {!!  Form::close()  !!}
    </div>

@stop