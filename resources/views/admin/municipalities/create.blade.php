@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    მუნიციპალიტეტის დამატება
@stop

{{-- Content --}}

@section('content')
    <section class="content-header">
        <h1>
            მუნიციპალიტეტის დამატება
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> მთავარი
                </a>
            </li>
            <li>
                <a href="{{ URL::to('admin/municipalities') }}"> <i class="livicon" data-name="bulb" data-size="16" data-color="#000"></i>
                    მუნიციპალიტეტები
                </a>
            </li>
            <li class="active">
                მუნიციპალიტეტის დამატება
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pr-3 pl-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title"> <i class="livicon" data-name="users-add" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            მუნიციპალიტეტის დამატება
                        </h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('url' => URL::to('admin/municipalities'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <div class="row">
                                <label for="name" class="col-sm-4 control-label">
                                    დასახელება
                                </label>
                                <div class="col-sm-4">
                                    {!! Form::text('name', old('name'), array('class' => 'form-control', 'placeholder'=>'დასახელება')) !!}
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('website', 'has-error') }}">
                            <div class="row">
                                <label for="title" class="col-sm-4 control-label">
                                    საიტის ლინკი
                                </label>
                                <div class="col-sm-4">
                                    {!! Form::text('website', old('website'), array('class' => 'form-control', 'placeholder'=>'ვებსაიტის მისამართი')) !!}
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('website', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="offset-sm-4 col-sm-4">
                                    <a class="btn btn-danger" href="{{ URL::to('admin/municipalities') }}">
                                        უარყოფა
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        შენახვა
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- row-->
    </section>
@stop