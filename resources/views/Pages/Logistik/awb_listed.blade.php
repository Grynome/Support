@php
    use App\Models\VW_Tiket_Part;
@endphp
@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Generate AWB</a></li>
                <li class="breadcrumb-item active" aria-current="page">Listed Part's</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <form action="{{ route('excel.lp') }}" method="post">
                                @csrf
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">
                                        <span class="input-group-text">
                                            List Data
                                        </span>
                                    </h6>
                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Download Excel" class="btn btn-inverse-success btn-icon-text">
                                        <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                                        Data
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>
                                        </th>
                                        <th>Notiket</th>
                                        <th>Case ID</th>
                                        <th>Service Point</th>
                                        <th>No HP</th>
                                        <th>QTY Part</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($listed_part as $item)
                                        <tr>
                                            <td>
                                                @if ($item->status_awb == 0)
                                                    <a href="{{ url("Ticket/AWB/Update=$item->notiket") }}">
                                                        <button type="button"
                                                            class="btn btn-inverse-primary btn-icon btn-sm">
                                                            <i data-feather="file"></i>
                                                        </button>
                                                    </a>
                                                    &nbsp;
                                                @endif
                                            </td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->service_name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->total_return }}</td>
                                            <td>
                                                @php
                                                    $val_awb_progress = VW_Tiket_Part::where('notiket', $item->notiket)
                                                        ->where(function ($query) {
                                                            $query->whereNull('awb_num')->orWhere('status', 0);
                                                        })
                                                        ->first();
                                                @endphp
                                                {{ !empty($val_awb_progress) && $item->status_awb == 0
                                                    ? 'Progress AWB'
                                                    : (empty($val_awb_progress) && $item->status_awb == 0
                                                        ? 'Set Done on AWB'
                                                        : ($item->status_awb == 1
                                                            ? 'AWB Finished'
                                                            : '')) }}
                                            </td>
                                            <td>
                                                <a href="{{ url("Detail/Ticket=$item->notiket") }}" target="_blank">
                                                    <button type="button" class="btn btn-inverse-success btn-icon btn-sm ">
                                                        <i data-feather="search"></i>
                                                    </button>
                                                </a>
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
    <script></script>
@endpush
