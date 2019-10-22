



@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    პროექტის კატეგორიის რედაქტირება
    @parent
@stop

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1>
            პროექტის კატეგორიის რედაქტირება
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="{{ URL::to('admin/project-categories') }}"> პროექტის კატეგორიები</a></li>
            <li class="active">პროექტის კატეგორიის რედაქტირება</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pl-3 pr-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card  ">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            პროექტის კატეგორიის რედაქტირება
                        </h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($projectcategory, ['url' => URL::to('admin/project-categories') . '/' . $projectcategory->id, 'method' => 'put', 'class' => 'form-horizontal']) !!}
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            <label for="name" class="col-sm-4 control-label">
                                პროექტის კატეგორიის რედაქტირება
                            </label>
                            <div class="col-sm-4">
                                {!! Form::text('name', $projectcategory->name, array('class' => 'form-control', 'placeholder'=>'დასახელება')) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-4">
                                <a class="btn btn-danger" href="{{ URL::to('admin/project-categories') }}">
                                    უარყოფა
                                </a>
                                <button type="submit" class="btn btn-success">
                                    რედაქტირება
                                </button>
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
