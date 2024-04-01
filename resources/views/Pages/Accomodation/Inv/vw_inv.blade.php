@php
    $user = auth()->user()->full_name;
@endphp
@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')

    <div class="page-content">
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="area-print">
                            <div class="container-fluid d-flex justify-content-between">
                                <img src="{{ asset('assets') }}/images/logo/HGT Reliable Partner logo.jpg" alt=""
                                    style="max-width: 18%; height:auto;" class="mb-3">
                                <div class="col-lg-3 pe-0 mt-4">
                                    <h1 class="fw-bolder text-uppercase text-end">request</h1>
                                    <h6 class="text-primary text-end">
                                        RQS/{{ $date }}/{{ $reqs->id }}</h6>
                                </div>
                            </div>
                            <div class="container-fluid d-flex justify-content-between">
                                <div class="row">
                                    <div class="col-lg-12 ps-0">
                                        <h6 class="mt-1 mb-2"><b>DITERBITKAN ATAS NAMA</b></h6>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="d-flex justify-content-between">
                                                    <p>User</p>
                                                    <div class="d-flex align-items-center flex-wrap text-nowrap">
                                                        <p class="me-2">:</p>
                                                        <h6><b>{{ $user }}</b></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 pe-0">
                                    <h6 class="mt-1 mb-2 text-start"><b>UNTUK</b></h6>
                                    <div class="d-flex justify-content-start">
                                        <p class="me-4">Engineer</p>
                                        <div class="d-flex flex-wrap text-nowrap">
                                            <p class="ms-3 me-2">:</p>
                                            <h6><b>{{ $reqs->full_name }}</b> ({{ $reqs->phone }})</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <p class="me-5">Lokasi</p>
                                        <div class="d-flex flex-wrap text-nowrap">
                                            <p class="ms-2 me-2">:</p>
                                            <h6><b>{{ $reqs->service_name }}</b></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <p class="me-5">Tujuan</p>
                                        <div class="d-flex flex-wrap text-nowrap">
                                            <p class="ms-1 me-2">:</p>
                                            <h6><b>{{ $reqs->refsTicket->gpi->go_end_user->end_user_name }}</b></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <p class="me-5">Project</p>
                                        <div class="d-flex flex-wrap text-nowrap">
                                            <p class="ms-1 me-2">:</p>
                                            <h6><b>{{ $reqs->refsTicket->gpi->go_jekfo->project_name }}</b></h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start">
                                        <p class="me-2">Date Request</p>
                                        <div class="d-flex flex-wrap text-nowrap">
                                            <p class="ms-1 me-2">:</p>
                                            <h6><b>{{ $reqs->refsTicket->ti->schedule }}</b></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-5 w-100">
                                <h6 class="mt-1 mb-2 text-start"><b>REFERENCES</b></h6>
                                <div class="table-responsive w-100">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Notiket</th>
                                                <th class="text-end">Case ID</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($getRef->refsTicket as $item)
                                                <tr class="text-end">
                                                    <td class="text-start">{{$no++}}</td>
                                                    <td class="text-start">{{$item->notiket}}</td>
                                                    <td class="text-start">{{$item->ti->case_id}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="container-fluid mt-3 d-flex justify-content-center w-100">
                                <div class="table-responsive w-100">
                                    <table class="table table-borderless">
                                        <thead class="head-group-inv">
                                            <tr>
                                                <th width="50%">
                                                    <h5 class="fw-bolder text-start text-dark">Deskripsi</h5>
                                                </th>
                                                <th>
                                                    <h5 class="fw-bolder text-center text-dark">Nominal</h5>
                                                </th>
                                                <th>
                                                    <h5 class="fw-bolder text-center text-dark">Total Konfirmasi</h5>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $tnominal = 0;
                                                $tact = 0;
                                            @endphp
                                            @foreach ($getDT as $item)
                                                <tr class="text-end">
                                                    <td>
                                                        <h5 class="fw-bolder text-start text-primary">
                                                            {{ $item->get_ctgr->description }}</h5>
                                                    </td>
                                                    <td>{{ 'Rp ' . number_format($item->nominal, 0, ',', '.') }}</td>
                                                    <td>{{ 'Rp ' . number_format($item->actual, 0, ',', '.') }}</td>
                                                </tr>
                                                @php
                                                    $tnominal += $item->nominal;
                                                    $tact += $item->actual;
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
                                                        <td class="text-bold-800">Total Nominal</td>
                                                        <td class="text-bold-800 text-end">
                                                            {{ 'Rp ' . number_format($tnominal, 2, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Konfirmasi</td>
                                                        <td class="bold-800 text-end">
                                                            {{ 'Rp ' . number_format($tact, 2, ',', '.') }}</td>
                                                    </tr>
                                                    <tr class="bg-light">
                                                        <td class="text-bold-800">Pembayaran</td>
                                                        <td class="text-danger text-end">(-)
                                                            {{ 'Rp ' . number_format($tnominal, 2, ',', '.') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid w-100">
                            <button onclick="printSpecificElement('.area-print')"
                                class="btn btn-outline-primary btn-icon-text float-end mt-4"><i data-feather="printer"
                                    class="me-2 btn-icon-prepend icon-md"></i>Print</button>
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
    <script>
        function printSpecificElement(selector) {
            var printContents = document.querySelector(selector).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
