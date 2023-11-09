@push('css-plugin')
@endpush
@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
@endphp
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Time's Square</h4>
            </div>
        </div>
        @foreach ($square as $item)
            <div class="row">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="row flex-grow-1">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card rounded">
                                <div class="card-header">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img class="img-xs rounded-circle" src="{{$item->user->profile}}"
                                                alt="">
                                            <div class="ms-2">
                                                <p>{{$item->user->full_name}}</p>
                                                <p class="tx-12 text-muted dif-selisih-waktu"
                                                    data-datetime="{{ $item->created_at }}"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    {!! $item->square !!}
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex post-actions">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/apexcharts/apexcharts.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/dashboard-light.js"></script>
@endpush
@push('custom')
@endpush