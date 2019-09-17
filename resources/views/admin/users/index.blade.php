@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
მომხმარებლების სია
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}" />
<link href="{{ asset('css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>მომხმარებლები</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                მთავარი
            </a>
        </li>
        <li><a href="#"> მომხმარებლები</a></li>
        <li class="active">სია</li>
    </ol>
</section>

<!-- Main content -->
<section class="content pl-3 pr-3">
    <div class="row">
        <div class="col-12">
        <div class="card ">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title my-2 float-left"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    მომხმარებლების სია
                </h4>
                 <!--<a href="{{ URL('admin/bulk_import_users') }}" class="float-right btn btn-success import_btn">
                                <i class="fa fa-plus fa-fw"></i>Bulk Import</a>-->
            </div>
            <div class="card-body">
                <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                <table class="table table-bordered width100" id="table">
                    <thead>
                        <tr class="filters">
                            <th>ID</th>
                            <th>სახელი</th>
                            <th>გვარი</th>
                            <th>ელ-ფოსტა</th>
                            <th>სტატუსი</th>
                            <th>რეგისტრაციის თარიღი</th>
                            <th>მოქმედებები</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    </div><!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.js') }}" ></script>

<script>
    $(function() {
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('admin.users.data') !!}/{{ request()->type }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status'},
                { data: 'created_at', name:'created_at'},
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        table.on( 'draw', function () {
            $('.livicon').each(function(){
                $(this).updateLivicon();
            });
        } );
    });

</script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">წაშლა</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    ნამდვილად გსურთ მომხმარებლის წაშლა?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">დახურვა</button>
                    <a  type="button" class="btn btn-danger Remove_square">წაშლა</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
var $url_path = '{!! url('/') !!}';
$('#delete_confirm').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var $recipient = button.data('id');
    var modal = $(this)
    modal.find('.modal-footer a').prop("href",$url_path+"/admin/users/"+$recipient+"/delete");
})
</script>
@stop
