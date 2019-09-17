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
                        {!! Form::open(array('url' => URL::to('admin/municipalities'), 'method' => 'post', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'files'=> true)) !!}
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

                        <div class="form-group {{ $errors->first('region_id', 'has-error') }}">
                            <div class="row">
                                <label for="region_id" class="col-sm-4 control-label">
                                    რეგიონი
                                </label>
                                <div class="col-sm-4">
                                    <select name="region_id" id="region_id" class="form-control">
                                        <option value="">აირჩიეთ რეგიონი</option>
                                        @foreach($regions as $region)
                                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('region_id', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group {{ $errors->first('image', 'has-error') }}">
                            <div class="row">
                                <label for="image" class="col-sm-4 control-label">სურათი</label>
                                <div class="col-sm-4">
                                    <input type="file" class="custom-file-input required" id="image" name="image">
                                    <label class="custom-file-label mx-3" for="image">აირჩიეთ სურათი...</label>
                                </div>
                                <span class="col-sm-4">{!! $errors->first('image', '<span class="help-block">:message</span>') !!}</span>
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