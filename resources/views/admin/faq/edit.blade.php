



@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    კითხვა-პასუხიის რედაქტირება
    @parent
@stop

{{-- Content --}}
@section('content')
    <section class="content-header">
        <h1>
            კითხვა-პასუხიის რედაქტირება
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="{{ URL::to('admin/faq') }}"> კითხვა-პასუხიები</a></li>
            <li class="active">კითხვა-პასუხიის რედაქტირება</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pl-3 pr-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card  ">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title"> <i class="livicon" data-name="question" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            კითხვა-პასუხიის რედაქტირება
                        </h4>
                    </div>
                    <div class="card-body">
                        {!! Form::model($faq, ['url' => URL::to('admin/faq') . '/' . $faq->id, 'method' => 'put', 'class' => 'form-horizontal']) !!}
                        <div class="form-group row {{ $errors->first('question', 'has-error') }}">
                            <label for="question" class="col-sm-4 control-label text-right">
                                კითხვა
                            </label>
                            <div class="col-sm-4">
                                {!! Form::text('question', $faq->question, array('id' => 'question', 'class' => 'form-control', 'placeholder'=>'კითხვა')) !!}
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('question', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->first('answer', 'has-error') }}">
                            <label for="answer" class="col-sm-4 control-label text-right">
                                პასუხი
                            </label>
                            <div class="col-sm-4">
                                <textarea id="answer" name="answer" class="form-control required">{{ $faq->answer }}</textarea>
                            </div>
                            <div class="col-sm-4">
                                {!! $errors->first('answer', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-4 col-sm-4 text-center">
                                <a class="btn btn-danger" href="{{ URL::to('admin/faq') }}">
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
@section('footer_scripts')

    <script src="{{ asset('vendors/tinymce/js/tinymce.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    // TinyMCE Full
    tinymce.init({
        selector: '#answer',
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
</script>
@stop