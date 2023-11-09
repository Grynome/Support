@extends('Theme/header')
@php
    use App\Models\VW_Act_Heldepsk;
    $no1 = 1;
    $no2 = 1;
    $no3 = 1;
    $no4 = 1;
@endphp
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - History Ticket</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if (!preg_match('/Week/', $timeframe))
                                    <h4 class="card-title">Detil Pending Each Month
                                    </h4>
                                    <h3>{{ $month . ' - ' . $year }}
                                    </h3>
                                @else
                                    <h4 class="card-title">Detil Pending Each Week
                                    </h4>
                                    <h3>{{ $timeframe . ' - ' . $month . ' - ' . $year }}
                                    </h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row grid-margin">
            <div class="d-none d-md-block col-md-3">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">Ticket Created</h6>
                        @foreach ($each_created as $item)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="me-2">
                                        <p>{{ $no1++; }}.</p>
                                    </div>
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37"
                                        alt="">
                                    <div class="ms-2">
                                        <p>{{ $item->full_name }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger fw-bolder ms-auto tx-13">{{$item->total_tiket}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">Ticket Handled</h6>
                        @foreach ($each_handled as $item)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="me-2">
                                        <p>{{ $no2++; }}.</p>
                                    </div>
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37"
                                        alt="">
                                    <div class="ms-2">
                                        <p>{{ $item->full_name }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger fw-bolder ms-auto tx-13">{{$item->tiket_handled}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">Activity in Ticket</h6>
                        @foreach ($each_act as $item)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="me-2">
                                        <p>{{ $no3++; }}.</p>
                                    </div>
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37"
                                        alt="">
                                    <div class="ms-2">
                                        <p>{{ $item->full_name }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger fw-bolder ms-auto tx-13">{{$item->activity_ticket}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">Ticket Closed</h6>
                        @foreach ($each_closed as $item)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="me-2">
                                        <p>{{ $no4++; }}.</p>
                                    </div>
                                    <img class="img-xs rounded-circle" src="https://via.placeholder.com/37x37"
                                        alt="">
                                    <div class="ms-2">
                                        <p>{{ $item->full_name }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger fw-bolder ms-auto tx-13">{{$item->total_close}}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection