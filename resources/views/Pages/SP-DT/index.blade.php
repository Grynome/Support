@push('css-plugin')
@endpush
@php
    use App\Models\VW_List_Engineer;
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detil SP</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Service Point Detil</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Service Name</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($sp as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->service_name }}</td>
                                            <td class="adds"
                                                style="text-align: center !important; vertical-align: middle; white-space: wrap;">
                                                {{ $item->alamat }}</td>
                                            <td>
                                                @if ($item->ownership == 1)
                                                    Owned
                                                @elseif ($item->ownership == 2)
                                                    Chanel
                                                @else
                                                    Unkown
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-primary btn-icon btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#see-dt-sp{{ $no }}">
                                                    <i data-feather="search"></i>
                                                </button>
                                                <div class="modal fade bd-example-modal-lg"
                                                    id="see-dt-sp{{ $no }}" tabindex="-1"
                                                    aria-labelledby="projectModal" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="projectModal">
                                                                    Detil Engineer in SP
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="table-responsive">
                                                                    <table id="display" class="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>No</th>
                                                                                <th>Engineer</th>
                                                                                <th>Email</th>
                                                                                <th>No. HP</th>
                                                                                <th>Chanel</th>
                                                                                <th>Work Type</th>
                                                                                <th>Service Name
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $get_en = VW_List_Engineer::all()->where('service_id', $item->service_id);
                                                                                $no1 = 1;
                                                                            @endphp
                                                                            @foreach ($get_en as $item)
                                                                                <tr>
                                                                                    <td>{{ $no1 }}</td>
                                                                                    <td>{{$item->full_name}}</td>
                                                                                    <td>{{$item->email}}</td>
                                                                                    <td>{{$item->phone}}</td>
                                                                                    <td>{{$item->cn}}</td>
                                                                                    <td>{{$item->work_type}}</td>
                                                                                    <td>{{$item->service_name}}</td>
                                                                                    @php
                                                                                        $no1++;
                                                                                    @endphp
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
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
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
@endpush
