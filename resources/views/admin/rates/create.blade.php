@extends('admin/layouts/default')

{{-- Web site Title --}}

@section('title')
    შეფასების დამატება
@stop

{{-- Content --}}

@section('content')
    <section class="content-header">
        <h1>
            შეფასების დამატება
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i> მთავარი
                </a>
            </li>
            <li>
                <a href="{{ URL::to('admin/rates') }}"> <i class="livicon" data-name="bulb" data-size="16" data-color="#000"></i>
                    შეფასებების სია
                </a>
            </li>
            <li class="active">
                შეფასების დამატება
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
                            შეფასების დამატება
                        </h4>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('url' => URL::to('admin/rates'), 'method' => 'post', 'class' => 'form-horizontal', 'files'=> true)) !!}
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <div class="row mb-3">
                                <label for="name" class="col-sm-4 control-label text-right">
                                    დასახელება
                                </label>
                                <div class="col-sm-4">
                                    {!! Form::text('name', old('name'), array('class' => 'form-control required', 'id' => 'name', 'placeholder'=>'დასახელება')) !!}
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('name', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="project_category_id" class="col-sm-4 control-label text-right">
                                    პროექტის კატეგორია
                                </label>
                                <div class="col-sm-4">
                                    <select class="form-control required" id="project_category_id">
                                        @foreach($projectCategories as $projectCategory)
                                            <option value="{{ $projectCategory->id }}" {{ old('project_category_id') == $projectCategory->id ? 'selected' : '' }}>{{ $projectCategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    {!! $errors->first('project_category_id', '<span class="help-block">:message</span> ') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 offset-4">
                                    <button class="btn btn-success btn-add-criteria mb-3">კრიტერიუმის დამატება</button>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row criteria-container">
                                        <label class="control-label col-sm-4 text-right">
                                            კრიტერიუმის დასახელება
                                        </label>
                                        <div class="col-sm-4">
                                            <input class="form-control" placeholder="კრიტერიუმის დასახელება" type="text" name="criteria[]" />
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-info">მნიშვნელობის დამატება</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="offset-sm-4 col-sm-4">
                                    <a class="btn btn-danger" href="{{ URL::to('admin/rates') }}">
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