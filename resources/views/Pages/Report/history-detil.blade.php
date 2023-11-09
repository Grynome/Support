@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('Report/data=History-Ticket') }}">Data History Ticket</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detil Report Data</li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Data Part</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="display" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Unit Name</th>
                                                <th>Type Part</th>
                                                <th>Status Delivery</th>
                                                <th>Send</th>
                                                <th>ETA</th>
                                                <th>Arrive</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no_part = 1;
                                            @endphp
                                            @foreach ($get_part as $item)
                                                <tr>
                                                    <td>{{ $no_part }}</td>
                                                    <td>{{ $item->unit_name }}</td>
                                                    <td>{{ $item->part_type }}</td>
                                                    <td>{{ $item->sts_journey }}</td>
                                                    <td>{{ $item->send }}</td>
                                                    <td>{{ $item->eta }}</td>
                                                    <td>{{ $item->arrive }}</td>
                                                </tr>
                                                @php
                                                    $no_part++;
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
        </div>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Activity Engineer</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="display" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>full_name</th>
                                                <th>On Site</th>
                                                <th>Received</th>
                                                <th>Go</th>
                                                <th>Arrive</th>
                                                <th>Work Start</th>
                                                <th>Work Stop</th>
                                                <th>Leave Site</th>
                                                <th>Travel Stop</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no_act = 1;
                                            @endphp
                                            @foreach ($activity as $item)
                                                <tr>
                                                    <td>{{ $no_act }}</td>
                                                    <td>{{ $item->full_name }}</td>
                                                    <td>{{ $item->OnSite }}</td>
                                                    <td>{{ $item->received }}</td>
                                                    <td>{{ $item->gow }}</td>
                                                    <td>{{ $item->arrived }}</td>
                                                    <td>{{ $item->work_start }}</td>
                                                    <td>{{ $item->work_stop }}</td>
                                                    <td>{{ $item->leave_site }}</td>
                                                    <td>{{ $item->travel_stop }}</td>
                                                </tr>
                                                @php
                                                    $no_act++;
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
        </div>
    </div>
@endsection
@push('custom')
@endpush
