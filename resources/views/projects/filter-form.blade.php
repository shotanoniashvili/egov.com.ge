<div class="project-filter">
    <form action="" method="get" class="form-horizontal">
        <div class="row">
            <div class="form-group col-sm-6 col-xs-12 col-md-3">
                <select class="form-control select2" data-placeholder="წლები" name="years[]" multiple>
                    @for($i = 2015; $i < (new DateTime())->format('Y'); $i++)
                        <option value="{{ $i }}" {{ (is_array(request()->years) && in_array($i, request()->years)) ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group col-sm-6 col-xs-12 col-md-4">
                <select class="form-control select2" data-placeholder="კატეგორიები" name="categories[]" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ (is_array(request()->categories) && in_array($category->id, request()->categories)) ? 'selected' : '' }}>{{ $category->name }} - {{ $category->year }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6 col-xs-12 col-md-4">
                <select class="form-control select2" data-placeholder="მუნიციპალიტეტები" name="municipalities[]" multiple>
                    @foreach($municipalities as $municipality)
                        <option value="{{ $municipality->id }}" {{ (is_array(request()->municipalities) && in_array($municipality->id, request()->municipalities)) ? 'selected' : '' }}>{{ $municipality->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12 col-xs-12 col-md-1">
                <button class="btn btn-outline-success"><i class="fa fa-search"></i> </button>
            </div>
        </div>
    </form>
</div>

@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/css/select2-bootstrap.css') }}" />
@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendors/select2/js/select2.js') }}"></script>
@stop
