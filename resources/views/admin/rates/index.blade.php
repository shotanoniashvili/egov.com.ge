

@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    შეფასებების სია
    @parent
@stop
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}" />
    <link href="{{ asset('css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Montent --}}
@section('content')
    <section class="content-header">
        <h1>შეფასებების სია</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="#"> შეფასებების სია</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pr-3 pl-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header bg-primary text-white clearfix">
                    <span class="float-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        შეფასებების სია
                    </span>
                        <div class="float-right">
                            <a href="{{ URL::to('admin/rates/create') }}" class="btn btn-sm btn-light"><span class="fa fa-plus"></span> დამატება</a>
                        </div>
                    </div>
                    <br />
                    <div class="card-body">
                        <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                            <table class="table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>დასახელება</th>
                                    <th>პროექტების კატეგორია</th>
                                    <th>მოქმედებები</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($rates as $rate)
                                    <tr>
                                        <td>{{ $rate->id }}</td>
                                        <td>{{ $rate->name }}</td>
                                        <td>{{ $rate->projectCategory->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.rates.edit', $rate->id) }}"><i
                                                        class="livicon" data-name="edit" data-size="18" data-loop="true"
                                                        data-c="#428BCA" data-hc="#428BCA"
                                                        title="რედაქტირება"></i></a>
                                            <a href="#" data-toggle="modal" data-id="{{ $rate->id }}" data-target="#delete_confirm">
                                                <i class="livicon" data-name="remove-alt" data-size="18"
                                                   data-loop="true" data-c="#f56954" data-hc="#f56954"
                                                   title="წაშლა"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">შეფასებები არ არსებობს</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>    <!-- row-->
    </section>

@stop
{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">შეფასების წაშლა</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    დარწმუნებული ხართ ხომ გსურთ წაშალოთ შეფასება?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">უარყოფა</button>
                    <a  type="button" class="btn btn-danger Remove_square">წაშლა</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });

        //        $(document).on("click", ".blogcategory_exists", function () {

        //            var group_name = $(this).data('name');
        //            $(".modal-header h4").text( group_name+" blog category" );
        //        });
        var $url_path = '{!! url('/') !!}';
        $('#delete_confirm').on('show.bs.modal', function (event) {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
            var button = $(event.relatedTarget);
            var $recipient = button.data('id');
            var modal = $(this);
            modal.find('.modal-footer a').prop("href",$url_path+"/admin/rates/"+$recipient+"/delete");
        })
    </script>
@stop
