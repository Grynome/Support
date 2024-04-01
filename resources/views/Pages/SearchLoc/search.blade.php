@push('css-plugin')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hind&amp;display=swap">
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Location</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Provinsi</h6>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="loc" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Provinsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($provinces as $item)
                                                    <tr>
                                                        <td>{{ $item->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Kabupaten</h6>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="loc" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cities as $item)
                                                    <tr>
                                                        <td>{{ $item->pv->name }}</td>
                                                        <td>{{ $item->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Kecamatan</h6>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table id="loc" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten</th>
                                                    <th>Kecamatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($district as $item)
                                                    <tr>
                                                        <td>{{ $item->kab->pv->name }}</td>
                                                        <td>{{ $item->kab->name }}</td>
                                                        <td>{{ $item->name }}</td>
                                                    </tr>
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
        </div> <!-- row -->
    </div>
@endsection
@push('custom')
@endpush
