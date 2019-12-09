<div class="modal fade" id="choseExpert" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">აირჩიეთ ექსპერტი</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-9">
                        <select class="form-control chose-experts">
                            @foreach($project->getEvaluatedExperts() as $expert)
                                <option value="{{ $expert->id }}">{{ $expert->fullname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary w-100 btn-chose">
                            არჩევა
                        </button>
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

@section('footer_scripts')
    <script type="text/javascript">
        $(function() {
             $('.btn-chose').on('click', function() {
                 let expertId = $('.chose-experts').val();
                 window.open('{{ url('/projects/'.$project->id.'/rating') }}/'+expertId, '_blank');
             });
        });
    </script>
@stop