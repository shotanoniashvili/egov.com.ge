

@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    რეპორტები პროექტების მიხედვით
    @parent
@stop
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}" />
    <link href="{{ asset('css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Montent --}}
@section('content')
    <section class="content-header">
        <h1>რეპორტები პროექტების მიხედვით</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="#"> რეპორტები პროექტების მიხედვით</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pr-3 pl-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header bg-primary text-white clearfix">
                    <span class="float-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        რეპორტები პროექტების მიხედვით
                    </span>
                    </div>
                    <br />
                    <div class="card-body">
                        <div class="table-responsive-lg table-responsive-sm table-responsive-md">
                            <table class="table table-bordered" id="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>პროექტის დასახელება</th>
                                    <th>მუნიციპალიტეტი</th>
                                    <th>თემატიკა / კატეგორია</th>
                                    <th>ქულების ჯამი</th>
                                    <th>საშუალო რეიტინგი</th>
                                    <th>მოქმედებები</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($projects as $project)
                                    <tr>
                                        <td>{{{ $project->id }}}</td>
                                        <td><a href="{{ route('admin.reports.show-project', $project->id) }}">{{{ $project->title }}}</a></td>
                                        <td>{{{ $project->municipality->name }}}</td>
                                        <td>{{{ $project->category->name }}}</td>
                                        <td>{{{ $project->rating_points }}}</td>
                                        <td>{{{ $project->getRating() }}}</td>
                                        <td>
                                            <a class="action-with-text" href="{{ route('admin.reports.show-project', $project->id) }}"><i
                                                        class="livicon" data-name="info" data-size="18" data-loop="true"
                                                        data-c="#428BCA" data-hc="#428BCA"
                                                        title="დეტალურად ნახვა"></i> დეტალურად ნახვა</a>
                                        </td>
                                    </tr>
                                @endforeach
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
            $('#table').DataTable({
                "iDisplayLength": 50
            });
        });
    </script>
@stop
