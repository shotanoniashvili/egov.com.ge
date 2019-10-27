@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    სიახლეები
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}"/>
    <link href="{{ asset('css/pages/tables.css') }}" rel="stylesheet" type="text/css"/>
@stop


{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>სიახლეები</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16"
                                                             data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li class="active">სიახლეები</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pl-3 pr-3">
        <div class="row">
            <div class="col-12">
            <div class="card ">
                <div class="card-header clearfix bg-primary text-white">
                    <span class="float-left"><i class="livicon" data-name="users" data-size="16"
                                                         data-loop="true" data-c="#fff" data-hc="white"></i>
                        სიახლეების
                    </span>
                    <div class="float-right">
                        <a href="{{ URL::to('admin/news/create') }}" class="btn btn-sm btn-light"><span
                                    class="fa fa-plus"></span> დამატება</a>
                    </div>
                </div>
                <br/>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                            <thead>
                            <tr class="filters">
                                <th>ID</th>
                                <th>სათაური</th>
                                <th>დამატების თარიღი</th>
                                <th>დრაფტი</th>
                                <th style="width: 70px">მოქმედებები</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        </div><!-- row-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.js') }}"></script>

    <script>
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.news.data') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'is_draft', name: 'is_draft'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
            table.on('draw', function () {
                $('.livicon').each(function () {
                    $(this).updateLivicon();
                });
            });

            $('body').on('click', '.toggle-draft', function() {
                let icon = $(this);
                let newsId = icon.data('id');

                $.get('{{ url()->to('/admin/news/toggle/is-draft') }}/'+newsId, function() {
                    toggleIcon(icon);
                });
            });
        });

        function toggleIcon(icon) {
            let successIcon = '<i class="livicon toggle-draft cursor-pointer" data-id="'+icon.data('id')+'" data-name="check-circle-alt" data-size="18" data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>';
            let warningIcon = '<i class="livicon toggle-draft cursor-pointer" data-id="'+icon.data('id')+'" data-name="remove-alt" data-size="18" data-c="#f56954" data-hc="#f56954" data-loop="true"></i>';

            if(icon.data('name') === 'check-circle-alt') {
                $(warningIcon).attr('class', icon.attr('class')).insertAfter(icon);
                icon.remove();
            } else {
                $(successIcon).attr('class', icon.attr('class')).insertAfter(icon);
                icon.remove();
            }

            $('.livicon').addLivicon();
        }
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">სიახლის წაშლა</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    დარწმუნებული ხართ რომ გსურთ სიახლის წაშლა?
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

        var $url_path = '{!! url('/') !!}';
        $('#delete_confirm').on('show.bs.modal', function (event) {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
            var button = $(event.relatedTarget);
            var $recipient = button.data('id');
            var modal = $(this);
            modal.find('.modal-footer a').prop("href",$url_path+"/admin/news/"+$recipient+"/delete");
        })
    </script>
@stop
