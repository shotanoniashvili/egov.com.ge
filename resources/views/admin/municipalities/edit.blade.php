@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    მუნიციპალიტეტის რედაქტირება
    @parent
@stop

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1>
            მუნიციპალიტეტის რედაქტირება
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="{{ URL::to('admin/municipalities') }}"> მუნიციპალიტეტები</a></li>
            <li class="active">მუნიციპალიტეტის რედაქტირება</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pl-3 pr-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card  ">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            მუნიციპალიტეტის რედაქტირება
                        </h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($municipality, ['url' => URL::to('admin/municipalities') . '/' . $municipality->id, 'method' => 'put', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <div class="row">
                                <label for="title" class="col-sm-4 control-label">
                                    მუნიციპალიტეტის რედაქტირება
                                </label>
                                <div class="col-sm-4">
                                    {!! Form::text('name', $municipality->name, array('class' => 'form-control', 'placeholder'=>'დასახელება')) !!}
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
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
                                            <option value="{{ $region->id }}" {{ $municipality->region_id == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
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
                                <label for="website" class="col-sm-4 control-label">
                                    მუნიციპალიტეტის რედაქტირება
                                </label>
                                <div class="col-sm-4">
                                    {!! Form::text('website', $municipality->website, array('class' => 'form-control', 'placeholder'=>'ვებგვერდის მისამართი')) !!}
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('website', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="offset-4 col-sm-4">
                                    <a class="btn btn-danger" href="{{ URL::to('admin/municipalities') }}">
                                        უარყოფა
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        რედაქტირება
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
