@php
    use Illuminate\Support\Facades\DB;
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - Each Month</li>
            </ol>
        </nav>

        <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Data Each Month</h4>
            </div>
            <form action="{{ route('sorting.eachMonth') }}" method="POST">
                @csrf
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if ($role != 15)
                        <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                            <select class="js-example-basic-single form-select" data-width="100%" name="chosen_prj_em">
                                <option value="">- Choose Project -</option>
                                @foreach ($project as $item)
                                    <option value="{{ $item->project_id }}"
                                        {{ $item->project_id == $prj_em ? 'selected' : '' }}>
                                        {{ $item->project_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="input-group wd-200 me-2 mb-2 mb-md-0">
                        <select class="js-example-basic-single form-select" data-width="100%" name="chosen_year_em">
                            <option value="">- Choose Year -</option>
                            @foreach ($loop_year as $years)
                                <option value="{{ $years }}" {{ $years == $year ? 'selected' : '' }}>
                                    {{ $years }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                        <i class="btn-icon-prepend" data-feather="search"></i>
                        Sort
                    </button>
            </form>
            <form action="{{ url('export/Monthly/Summary-Ticket') }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $year }}" name="yr_mtl_tc">
                <button type="submit" class="btn btn-success btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                    Download Excel
                </button>
            </form>
        </div>
    </div>
    @if ($role != 15)
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>Timeframe</th>
                                        <th>Total Ticket</th>
                                        <th>Pending</th>
                                        <th>Close</th>
                                        <th>Cancel</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($eachMonth as $item)
                                        <tr>
                                            <td>{{ $item->month_name }}</td>
                                            <td>{{ $item->data_count }}</td>
                                            <td>{{ $item->pending }}</td>
                                            <td>{{ $item->close_sum }}</td>
                                            <td>{{ $item->cancel_sum }}</td>
                                            <td>
                                                @if (!empty($item->pending))
                                                    @php
                                                        if (empty($prj_em)) {
                                                            $project = 'null';
                                                        } else {
                                                            $project = $prj_em;
                                                        }
                                                    @endphp
                                                    <a
                                                        href="{{ url("Pending-EM/Timeframe=$item->month_number/$project/$year") }}">
                                                        <button class="btn btn-outline-dark btn-icon-text btn-sm">
                                                            <i class="btn-icon-prepend" data-feather="search"></i>Pending
                                                        </button>
                                                    </a>
                                                    &nbsp;
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr style="background-color: #e9ecef80 236, 239, 0.5);">
                                        <th>Summary</th>
                                        <th>{{ $total_entry }}</th>
                                        <th>{{ $total_pending }}</th>
                                        <th>{{ $total_close }}</th>
                                        <th>{{ $total_cancel }}</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($role == 15 || $role == 20)
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="">Information :</label><br>
                            <div class="badge rounded-pill bg-created ms-auto">
                                <h6>Created</h6>
                            </div>
                            <div class="badge rounded-pill bg-pending ms-auto">
                                <h6>Pending</h6>
                            </div>
                            <div class="badge rounded-pill bg-close ms-auto">
                                <h6>Close</h6>
                            </div>
                        </div>
                        <div class="table-responsive t-scroll">
                            <table id="d-Monthly" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Partner</th>
                                        <th rowspan="2" id="col-sticky">Project</th>
                                        <th colspan="4">Jan</th>
                                        <th colspan="4">Feb</th>
                                        <th colspan="4">March</th>
                                        <th colspan="4">April</th>
                                        <th colspan="4">May</th>
                                        <th colspan="4">June</th>
                                        <th colspan="4">July</th>
                                        <th colspan="4">August</th>
                                        <th colspan="4">Sept</th>
                                        <th colspan="4">Oct</th>
                                        <th colspan="4">Nov</th>
                                        <th colspan="4">DEC</th>
                                    </tr>
                                    <tr>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                        <th>CR</th>
                                        <th>PN</th>
                                        <th>CL</th>
                                        <th>CCL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $noc = 1;
                                    @endphp
                                    @foreach ($compare as $item)
                                        <tr>
                                            <td>{{ $noc }}</td>
                                            <th>{{ $item->partner }}</th>
                                            <th id="col-sticky">{{ $item->project_name }}</th>
                                            <td
                                                style="background-color: {{ $item->total1 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total1 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending1 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending1 }}</td>
                                            <td
                                                style="background-color: {{ $item->close1 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close1 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel1 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel1 }}</td>
                                            <td
                                                style="background-color: {{ $item->total2 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total2 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending2 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending2 }}</td>
                                            <td
                                                style="background-color: {{ $item->close2 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close2 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel2 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel2 }}</td>
                                            <td
                                                style="background-color: {{ $item->total3 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total3 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending3 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending3 }}</td>
                                            <td
                                                style="background-color: {{ $item->close3 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close3 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel3 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel3 }}</td>
                                            <td
                                                style="background-color: {{ $item->total4 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total4 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending4 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending4 }}</td>
                                            <td
                                                style="background-color: {{ $item->close4 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close4 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel4 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel4 }}</td>
                                            <td
                                                style="background-color: {{ $item->total5 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total5 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending5 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending5 }}</td>
                                            <td
                                                style="background-color: {{ $item->close5 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close5 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel6 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel6 }}</td>
                                            <td
                                                style="background-color: {{ $item->total6 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total6 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending6 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending6 }}</td>
                                            <td
                                                style="background-color: {{ $item->close6 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close6 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel6 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel6 }}</td>
                                            <td
                                                style="background-color: {{ $item->total7 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total7 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending7 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending7 }}</td>
                                            <td
                                                style="background-color: {{ $item->close7 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close7 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel7 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel7 }}</td>
                                            <td
                                                style="background-color: {{ $item->total8 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total8 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending8 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending8 }}</td>
                                            <td
                                                style="background-color: {{ $item->close8 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close8 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel8 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel8 }}</td>
                                            <td
                                                style="background-color: {{ $item->total9 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total9 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending9 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending9 }}</td>
                                            <td
                                                style="background-color: {{ $item->close9 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close9 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel9 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel9 }}</td>
                                            <td
                                                style="background-color: {{ $item->total10 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total10 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending10 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending10 }}</td>
                                            <td
                                                style="background-color: {{ $item->close10 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close10 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel10 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel10 }}</td>
                                            <td
                                                style="background-color: {{ $item->total11 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total11 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending11 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending11 }}</td>
                                            <td
                                                style="background-color: {{ $item->close11 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close11 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel11 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel11 }}</td>
                                            <td
                                                style="background-color: {{ $item->total12 != 0 ? '#36A2EB' : 'transparent' }}">
                                                {{ $item->total12 }}</td>
                                            <td
                                                style="background-color: {{ $item->pending12 != 0 ? '#FFCE56' : 'transparent' }}">
                                                {{ $item->pending12 }}</td>
                                            <td
                                                style="background-color: {{ $item->close12 != 0 ? '#05a34a' : 'transparent' }}">
                                                {{ $item->close12 }}</td>

                                            <td
                                                style="background-color: {{ $item->cancel12 != 0 ? '#7987a1' : 'transparent' }}">
                                                {{ $item->cancel12 }}</td>
                                        </tr>
                                        @php
                                            $noc++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>
@endsection
