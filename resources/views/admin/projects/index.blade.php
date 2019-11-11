@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
პროექტების სია
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
    <h1>პროექტები</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                მთავარი
            </a>
        </li>
        <li><a href="#"> პროექტები</a></li>
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
                    პროექტების სია
                </h4>
                 <!--<a href="{{ URL('admin/bulk_import_users') }}" class="float-right btn btn-success import_btn">
                                <i class="fa fa-plus fa-fw"></i>Bulk Import</a>-->
                <div class="float-right">
                    <a href="{{ URL::to('admin/projects/create') }}" class="btn btn-sm btn-light"><span class="fa fa-plus"></span> დამატება</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                    <table class="table table-bordered width100" id="table">
                        <thead>
                            <tr class="filters">
                                <th>ID</th>
                                <th>დასახელება</th>
                                <th>თემატიკა</th>
                                <th>მუნიციპალიტეტი</th>
                                <th>არქივი</th>
                                <th>წელი</th>
                                <th>რეიტინგი</th>
                                <th>საუკეთესო პრაქტიკა</th>
                                <th>გამოუჩნდეთ ექსპერტებს</th>
                                <th>გამოჩნდეს საიზე</th>
                                <th>მოქმედებები</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($projects) > 0)
                            @foreach ($projects as $project)
                                <tr data-id="{{ $project->id }}">
                                    <td>{{ $project->id }}</td>
                                    <td><a target="_blank" href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a></td>
                                    <td>{{ $project->category->name }}</td>
                                    <td><a target="_blank" href="{{ route('municipalities.show', $project->municipality->id) }}">{{ $project->municipality->name }}</a></td>
                                    <td class="text-center">{!! $project->is_archive ? '<i class="livicon toggle-is-archive cursor-pointer" data-name="check-circle-alt" data-size="18"
                                                   data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>' : '<i class="livicon toggle-is-archive cursor-pointer" data-name="remove-alt" data-size="18"
                                                   data-c="#f56954" data-hc="#f56954" data-loop="true"></i>' !!}</td>
                                    <td>{{ $project->created_at->format('Y') }}</td>
                                    <td>{{ $project->getRating() }}</td>
                                    <td class="text-center">{!! $project->is_best_practise ? '<i class="livicon toggle-best-practise cursor-pointer" data-name="check-circle-alt" data-size="18"
                                                   data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>' : '<i class="livicon toggle-best-practise cursor-pointer" data-name="remove-alt" data-size="18"
                                                   data-c="#f56954" data-hc="#f56954" data-loop="true"></i>' !!}</td>
                                    <td class="text-center">{!! $project->is_active_for_experts ? '<i class="livicon toggle-activation-for-experts cursor-pointer" data-name="check-circle-alt" data-size="18"
                                                   data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>' : '<i class="livicon toggle-activation-for-experts cursor-pointer" data-name="remove-alt" data-size="18"
                                                   data-c="#f56954" data-hc="#f56954" data-loop="true"></i>' !!}</td>
                                    <td class="text-center">{!! $project->is_active_for_web ? '<i class="livicon toggle-activation-for-web cursor-pointer" data-name="check-circle-alt" data-size="18"
                                                   data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>' : '<i class="livicon toggle-activation-for-web cursor-pointer" data-name="remove-alt" data-size="18"
                                                   data-c="#f56954" data-hc="#f56954" data-loop="true"></i>' !!}</td>
                                    <td>
                                        <a href="{{ URL::to('admin/projects/edit/' . $project->id) }}"><i
                                                    class="livicon" data-name="edit" data-size="18" data-loop="true"
                                                    data-c="#428BCA" data-hc="#428BCA"
                                                    title="რედაქტირება"></i></a>
                                        <a href="{{ route('admin.projects.confirm-delete', $project->id) }}" data-toggle="modal" data-id="{{ $project->id }}" data-target="#delete_confirm">
                                            <i class="livicon" data-name="remove-alt" data-size="18"
                                               data-loop="true" data-c="#f56954" data-hc="#f56954"
                                               title="წაშლა"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteLabel">პროექტის წაშლა</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    დარწმუნებული ხართ ხომ გსურთ წაშალოთ პროექტი?
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
            }).on('click', '.toggle-activation-for-experts', function() {
                let icon = $(this);
                let projectId = icon.parent().parent().data('id');

                $.get('{{ url()->to('/admin/projects/toggle/is-active-for-experts') }}/'+projectId, function() {
                    toggleIcon(icon);
                });
            }).on('click', '.toggle-activation-for-web', function() {
                let icon = $(this);
                let projectId = icon.parent().parent().data('id');

                $.get('{{ url()->to('/admin/projects/toggle/is-active-for-web') }}/'+projectId, function() {
                    toggleIcon(icon);
                });
            }).on('click', '.toggle-best-practise', function() {
                let icon = $(this);
                let projectId = icon.parent().parent().data('id');

                $.get('{{ url()->to('/admin/projects/toggle/is-best-practise') }}/'+projectId, function() {
                    toggleIcon(icon);
                });
            });

            $('.toggle-is-archive').on('click', function() {
                let row = $(this).parent().parent();
                let projectId = row.data('id');

                $.get('{{ url()->to('/admin/projects/toggle/is-archive') }}/'+projectId, function() {
                    row.remove();
                });
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
            modal.find('.modal-footer a').prop("href",$url_path+"/admin/projects/delete/"+$recipient);
        });

        function toggleIcon(icon) {
            let successIcon = '<i class="livicon" data-name="check-circle-alt" data-size="18" data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>';
            let warningIcon = '<i class="livicon" data-name="remove-alt" data-size="18" data-c="#f56954" data-hc="#f56954" data-loop="true"></i>';

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
@stop
