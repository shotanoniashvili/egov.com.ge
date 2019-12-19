

@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
    რეპორტები კატეგორიის მიხედვით - {{ $category->name }}
    @parent
@stop
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/datatables/css/dataTables.bootstrap4.css') }}" />
    <link href="{{ asset('css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Montent --}}
@section('content')
    <section class="content-header">
        {{--<h1>რეპორტები კატეგორიის მიხედვით - {{ $category->name }}</h1>--}}
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    მთავარი
                </a>
            </li>
            <li><a href="#"> რეპორტები კატეგორიის მიხედვით - {{ $category->name }}</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content pr-3 pl-3">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header bg-primary text-white clearfix">
                        <span class="float-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            რეპორტები კატეგორიის მიხედვით - {{ $category->name }}
                        </span>
                        <div class="float-right">
                            <a href="{{ route('admin.reports.categories.export', $category->id) }}" class="btn btn-sm btn-light"><span class="fa fa-file-excel"></span> ექსპორტი</a>
                        </div>
                    </div>
                    <br />
                    <div class="card-body">
                        @forelse($category->projects()->evaluated()->get() as $project)

                            <div class="row border-bottom pb-3 mb-3">
                                <div class="col-md-2">
                                    <a target="_blank" href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                                    (<a target="_blank" href="{{ route('municipalities.show', $project->municipality->id) }}">{{ $project->municipality->name }}</a>)
                                </div>
                                <div class="col-md-10">
                                    <table>
                                        <tr>
                                            <th>
                                                ექსპერტი
                                            </th>
                                            <th>
                                                წარმატებული
                                            </th>
                                            <th>
                                                გამჭვირვალე
                                            </th>
                                            <th>
                                                ადეკვატური
                                            </th>
                                            <th>
                                                გაზიარებადი
                                            </th>
                                            <th>
                                                მდგრადი
                                            </th>
                                            <th>
                                                ჯამური ქულა
                                            </th>
                                            <th>
                                                შეფასების თარიღი
                                            </th>
                                            <th>
                                                &nbsp;
                                            </th>
                                        </tr>
                                        @foreach($project->getEvaluatedExperts() as $expert)
                                            <tr>
                                                <td>
                                                    {{ $expert->fullname }}
                                                </td>
                                                <td>
                                                    {{ $project->evaluations()->expert($expert->id)->success()->sum('subevaluations.point') }}
                                                </td>
                                                <td>
                                                    {{ $project->evaluations()->expert($expert->id)->transparent()->sum('subevaluations.point') }}
                                                </td>
                                                <td>
                                                    {{ $project->evaluations()->expert($expert->id)->adequate()->sum('subevaluations.point') }}
                                                </td>
                                                <td>
                                                    {{ $project->evaluations()->expert($expert->id)->shareable()->sum('subevaluations.point') }}
                                                </td>
                                                <td>
                                                    {{ $project->evaluations()->expert($expert->id)->sustainable()->sum('subevaluations.point') }}
                                                </td>
                                                <td>
                                                    {{ $project->getRatingSumByExpert($expert->id) }}
                                                </td>
                                                <td>
                                                    {{ $project->evaluations()->expert($expert->id)->first()->created_at->format('d-m-Y H:i:s') }}
                                                </td>
                                                <td>
                                                    <a target="_blank" href="{{ route('projects.rating', [$project->id, $expert->id]) }}"><i
                                                                class="livicon" data-name="info" data-size="18" data-loop="true"
                                                                data-c="#428BCA" data-hc="#428BCA"
                                                                title="დეტალურად ნახვა"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @empty
                            შეფასებული პროექტები არ არსებობს
                        @endforelse
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
@stop
