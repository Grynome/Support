@php
    $user = auth()->user()->full_name;
@endphp
@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')

    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Financial Outlay</li>
            </ol>
        </nav>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="container-fluid d-flex justify-content-between">
                            <img src="{{ asset('assets') }}/images/logo/HGT Reliable Partner logo.jpg" alt=""
                                style="max-width: 18%; height:auto;" class="mb-3">
                            <div class="col-lg-3 pe-0 mt-4">
                                <h1 class="fw-bolder text-uppercase text-end">request</h1>
                                <h6 class="text-end"># RQS-000001</h6>
                            </div>
                        </div>
                        <div class="container-fluid d-flex justify-content-between">
                            <div class="col-lg-2 ps-0">
                                <h6 class="mt-1 mb-2"><b>DITERBITKAN ATAS NAMA</b></h6>
                                <div class="d-flex justify-content-between">
                                    <p>User</p>
                                    <div class="d-flex align-items-center flex-wrap text-nowrap">
                                        <p class="me-2">:</p>
                                        <h6><b>{{ $user }}</b></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 pe-0">
                                <h6 class="mt-1 mb-2 text-start"><b>UNTUK</b></h6>
                                <div class="d-flex justify-content-start">
                                    <p class="me-4">Engineer</p>
                                    <div class="d-flex flex-wrap text-nowrap">
                                        <p class="ms-3 me-2">:</p>
                                        <h6><b>{{ $reqs->full_name }}</b> ({{ $reqs->phone }})</h6>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start">
                                    <p class="me-2">Date Request</p>
                                    <div class="d-flex flex-wrap text-nowrap">
                                        <p class="ms-1 me-2">:</p>
                                        <h6><b>{{ $reqs->reqs_at }}</b></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                            <div class="table-responsive w-100">
                                <table class="table table-borderless">
                                    <thead class="head-group-inv">
                                        <tr>
                                            <th width="50%">
                                                <h5 class="fw-bolder text-start text-dark">Description</h5>
                                            </th>
                                            <th>
                                                <h5 class="fw-bolder text-center text-dark">Nominal</h5>
                                            </th>
                                            <th>
                                                <h5 class="fw-bolder text-center text-dark">Actual</h5>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $tnominal = 0;
                                        @endphp
                                        @foreach ($getDT as $item)
                                            <tr class="text-end">
                                                <td>
                                                    <h5 class="fw-bolder text-start text-secondary">
                                                        {{ $item->get_ctgr->description }}</h5>
                                                </td>
                                                <td>{{ 'Rp ' . number_format($item->nominal, 0, ',', '.') }}</td>
                                                <td>{{ 'Rp ' . number_format($item->actual, 0, ',', '.') }}</td>
                                            </tr>
                                            @php
                                                $tnominal += $item->nominal;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container-fluid mt-5 w-100">
                            <div class="row">
                                <div class="col-md-6 ms-auto">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="text-bold-800">Total</td>
                                                    <td class="text-bold-800 text-end">
                                                        {{ 'Rp ' . number_format($tnominal, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Payment Made</td>
                                                    <td class="text-danger text-end">(-)
                                                        {{ 'Rp ' . number_format($tnominal, 2, ',', '.') }}</td>
                                                </tr>
                                                <tr class="bg-light">
                                                    <td class="text-bold-800">Balance Due</td>
                                                    <td class="text-bold-800 text-end">$ 12,000.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid w-100">
                            <a href="javascript:;" class="btn btn-primary float-end mt-4 ms-2"><i data-feather="send"
                                    class="me-3 icon-md"></i>Send Invoice</a>
                            <a href="javascript:;" class="btn btn-outline-primary float-end mt-4"><i data-feather="printer"
                                    class="me-2 icon-md"></i>Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
@endpush
