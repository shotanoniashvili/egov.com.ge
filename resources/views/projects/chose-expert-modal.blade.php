<div class="modal fade" id="choseExpert" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">აირჩიეთ ექსპერტი</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        საერთო შეფასების საშუალო ქულა: {{ $project->getRating() }}
                    </div>
                    <div class="col-md-12">
                        საერთო შეფასების ჯამური ქულა: {{ $project->rating_points }}
                    </div>
                    <div class="col-md-12 mt-3">
                        @foreach($project->category->experts as $expert)
                            @if($project->isEvaluatedByExpert($expert->id))
                                <a class="d-block" href="{{ route('projects.rating', [$project->id, $expert->id]) }}"><span class="success">{{ $expert->fullname }}</span>
                                    <span class="text-muted small">({{ $project->getRatingSumByExpert($expert->id) }} ქულა)</span>
                                </a>
                            @else
                                <span class="d-block danger">{{ $expert->fullname }} <span class="text-muted small">(არ არის შეფასებული)</span></span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">დახურვა</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>