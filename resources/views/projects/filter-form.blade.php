<div class="project-filter">
    <form action="" method="get" class="form-horizontal">
        <div class="row">
            <div class="form-group col-sm-6 col-xs-12 col-md-2">
                <select class="form-control" name="rating">
                    <option value="">წელი</option>
                </select>
            </div>
            <div class="form-group col-sm-6 col-xs-12 col-md-3">
                <select class="form-control" name="winner">
                    <option value="">გამარჯვებული</option>
                </select>
            </div>
            <div class="form-group col-sm-6 col-xs-12 col-md-3">
                <select class="form-control" name="category">
                    <option value="">კატეგორიები</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-6 col-xs-12 col-md-3">
                <select class="form-control" name="municipality">
                    <option value="">მუნიციპალიტეტი</option>
                    @foreach($municipalities as $municipality)
                        <option value="{{ $municipality->id }}" {{ request()->get('municipality') == $municipality->id ? 'selected' : '' }}>{{ $municipality->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-12 col-xs-12 col-md-1">
                <button class="btn btn-outline-success"><i class="fa fa-search"></i> </button>
            </div>
        </div>
    </form>
</div>