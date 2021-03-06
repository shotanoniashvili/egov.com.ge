@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    სიახლის დამატება :: @parent
@stop

{{-- page level styles --}}
@section('header_styles')

    <link href="{{ asset('vendors/summernote/css/summernote.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('vendors/summernote/css/summernote-bs4.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/pages/blog.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}">
    <!--end of page level css-->
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>სიახლის დამატება</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="14"
                                                             data-c="#000" data-loop="true"></i>
                    მთავარი
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news.index') }}">სიახლეები</a>
            </li>
            <li class="active">სიახლის დამატება</li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content pr-3 pl-3">
        <!--main content-->
        <div class="row">
            <div class="col-12">
            <div class="the-box no-border">
                <!-- errors -->
                {!! Form::open(array('url' => URL::to('admin/news'), 'id' => 'newsForm', 'method' => 'post', 'class' => 'bf', 'files'=> true)) !!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="row">
                    <div class="col-sm-8">
                        <label>სათაური</label>
                        <div class="form-group {{ $errors->first('title', 'has-error') }}">
                            {!! Form::text('title', null, array('class' => 'form-control input-lg','placeholder'=> 'სათაური')) !!}
                            <span class="help-block">{{ $errors->first('title', ':message') }}</span>
                        </div>
                        <div class='box-body pad form-group {{ $errors->first('content', 'has-error') }}'>
                            {!! Form::textarea('content', NULL, array('placeholder'=>'სიახლის ტექსტი','rows'=>'5','class'=>'textarea form-control','id'=>'content')) !!}
                            <span class="help-block">{{ $errors->first('content', ':message') }}</span>
                        </div>
                    </div>
                    <!-- /.col-sm-8 -->
                    <div class="col-sm-4">

                        <div class="form-group {{ $errors->first('image', 'has-error') }}">
                            <label class="control-label col-12">სურათი</label>
                            <div class="col-12 fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <img src="{{ asset('images/authors/no_avatar.jpg') }}" alt="..."
                                         class="img-responsive"/>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"
                                     style="max-width: 200px; max-height: 150px;">

                                </div>
                                <div>
                                            <span class="btn btn-primary btn-file">
                                                <span class="fileinput-new">სურათის არჩევა</span>
                                                <span class="fileinput-exists">შეცვლა</span>
                                                <input type="file" name="image" id="pic" accept="image/*"/>
                                            </span>
                                    <span class="btn btn-primary fileinput-exists"
                                          data-dismiss="fileinput">წაშლა</span>
                                </div>
                                <span class="help-block">{{ $errors->first('image', ':message') }}</span>
                            </div>
                        </div>
                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-success">გამოქვეყნება</button>
                            <button class="btn btn-info btn-save-draft">დრაფტში შენახვა</button>
                            <a href="{!! URL::to('admin/news/create') !!}"
                               class="btn btn-danger">უარყოფა</a>
                        </div>
                    </div>
                    <input type="hidden" name="is_draft" id="isDraft" value="" />
                    <!-- /.col-sm-4 --> </div>
                {!! Form::close() !!}
            </div>
        </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page level js -->
    <!--edit blog-->
    <script src="{{ asset('vendors/summernote/js/summernote.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('vendors/summernote/js/summernote-bs4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/select2/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/tinymce/js/tinymce.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/pages/add_newblog.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            $('.btn-save-draft').on('click', function() {
                $('#isDraft').val('1');
                $('#newsForm').submit();
            });


            // TinyMCE Full
            tinymce.init({
                selector: '#content',
                theme: 'modern',
                plugins: [
                    'advlist autolink lists link charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'template paste textcolor',
                ],
                toolbar1:
                    'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview | forecolor backcolor',
            });
        });
    </script>
@stop
