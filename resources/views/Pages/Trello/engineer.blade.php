@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Trello Engineer</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="card-title">Since 2 days Ago</h6>
                                <p class="form-label fw-bolder">
                                    Ticket Not Yet Closed
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        <th>Project</th>
                                        <th>Engineer</th>
                                        <th>Schedule</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $noY = 1;
                                    @endphp
                                    @foreach ($kamari as $item)
                                        <tr>
                                            <td>{{ $noY }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->departure }}</td>
                                            <td>
                                                <a href="{{ url("Detail/Ticket=$item->notiket") }}">
                                                    <button type="button" class="btn btn-inverse-info btn-icon btn-sm">
                                                        <i data-feather="search"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $noY++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="card-title">Next Day</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        <th>Project</th>
                                        <th>Engineer</th>
                                        <th>Schedule</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $noT = 1;
                                    @endphp
                                    @foreach ($tomorow as $item)
                                        <tr>
                                            <td>{{ $noT }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->departure }}</td>
                                            <td>
                                                <a href="{{ url("Detail/Ticket=$item->notiket") }}">
                                                    <button type="button" class="btn btn-inverse-info btn-icon btn-sm">
                                                        <i data-feather="search"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $noT++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col">
                                <h6 class="card-title">Overmorrow</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        <th>Project</th>
                                        <th>Engineer</th>
                                        <th>Schedule</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $noDaT = 1;
                                    @endphp
                                    @foreach ($lusa as $item)
                                        <tr>
                                            <td>{{ $noDaT }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->full_name }}</td>
                                            <td>{{ $item->departure }}</td>
                                            <td>
                                                <a href="{{ url("Detail/Ticket=$item->notiket") }}">
                                                    <button type="button" class="btn btn-inverse-info btn-icon btn-sm">
                                                        <i data-feather="search"></i>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                        @php
                                            $noDaT++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
