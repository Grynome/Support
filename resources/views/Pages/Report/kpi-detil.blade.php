@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('Report/data=KPI-User')}}">Data Report KPI</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detil Report KPI</li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Range Timeline Activity Engineer</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="display" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Visiting</th>
                                                <th>Go</th>
                                                <th>Arrive</th>
                                                <th>Start Work</th>
                                                <th>Stop Work</th>
                                                <th>Leave Site</th>
                                                <th>Travel Stop</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $number = 1;
                                            @endphp
                                            @foreach ($get_enkpi_dt as $item)
                                                <tr>
                                                    <td>{{ $number }}</td>
                                                    <td>{{ $item->visiting }}</td>
                                                    <td>
                                                        @if ($item->sts_timeline == 0)
                                                            {{ $item->act_12 }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->act_23 }}</td>
                                                    <td>{{ $item->act_34 }}</td>
                                                    <td>{{ $item->act_45 }}</td>
                                                    <td>{{ $item->act_56 }}</td>
                                                    <td>{{ $item->act_67 }}</td>
                                                </tr>
                                                @php
                                                    $number++;
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
                                                <th>Engineer</th>
                                                <th>Status</th>
                                                <th>On Site</th>
                                                <th>Action At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no_act = 1;
                                            @endphp
                                            @foreach ($get_act_en as $item)
                                                @if ($item->act_description == 2)
                                                    <tr style="background-color: rgba(142, 142, 142, 0.2);">
                                                    @elseif($item->act_description == 8)
                                                    <tr style="background: rgba(205, 147, 59, 0.2);">
                                                    @elseif($item->act_description == 9)
                                                    <tr style="background: rgba(102, 209, 209, 0.2);">
                                                    @else
                                                    <tr>
                                                @endif
                                                <td>{{ $no_act }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->sts_ticket }}</td>
                                                <td>
                                                    @if ($item->sts_timeline == 0)
                                                        Ke-1
                                                    @elseif ($item->sts_timeline == 1)
                                                        Ke-2
                                                    @else
                                                        Ke-3
                                                    @endif
                                                </td>
                                                <td>{{ $item->act_time }}</td>
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
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Log Note Helpdesk</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="display" class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Note</th>
                                                <th>User</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no_note = 1;
                                            @endphp
                                            @foreach ($get_note as $item)
                                                <tr>
                                                    <td>{{ $no_note }}</td>
                                                    <td>{{ $item->note }}</td>
                                                    <td>{{ $item->full_name }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                </tr>
                                                @php
                                                    $no_note++;
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