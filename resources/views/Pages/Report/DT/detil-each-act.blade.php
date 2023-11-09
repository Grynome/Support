@extends('Theme/header')
@php
    $no1 = 1;
@endphp
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - Activity Each Engineer in {{$vdt}}</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Detil Activity Each {{$vdt}}
                                </h4>
                                @if ($vdt == 'Week')
                                    <h3>{{ $timeframe . ' - ' . $month . ' - ' . $year }}
                                    </h3>
                                @else
                                    <h3>{{ $month . ' - ' . $year }}
                                    </h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card rounded">
                    <div class="card-body">
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <h6 class="card-title">Engineery on Duty</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <h6>Executed</h6>
                                    </div>
                                    |
                                    <div class="ms-2">
                                        <h6>Schedule</h6>
                                    </div>
                                </div>
                            </div>
                        @foreach ($gedtActEN as $item)
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
                                    <button class="btn btn-outline-dark btn-text btn-xs me-3">
                                        {{$item->totalOnDuty}}
                                    </button>
                                    &nbsp; | &nbsp;
                                    <button class="btn btn-outline-dark btn-text btn-xs ms-3">
                                        @if (empty($item->sumSchedule))
                                            0
                                        @else
                                            {{$item->sumSchedule}}
                                        @endif
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection