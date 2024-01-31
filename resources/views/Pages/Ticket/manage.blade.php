@push('css-plugin')
@endpush
@php
    use App\Models\VW_Tiket_Part;
    use App\Models\ActivityL2En;
    use App\Models\RefReqs;
    use App\Models\TiketPartDetail;
    use App\Models\TiketPartNew;
    use Carbon\Carbon;
    $role = auth()->user()->role;
    $nik = auth()->user()->nik;
    $depart = auth()->user()->depart;
    $ar_sts = [1, 2, 3, 4, 5];
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Manage Ticket</li>
                <li class="breadcrumb-item active" aria-current="page">Open</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <h6 class="card-title">Manage Ticket</h6>
                            </div>
                            <div class="col-md-3">
                                @if ($depart == 4 || $role == 20 || $role == 15 || $depart == 3 || $depart == 5)
                                    <button type="button" class="btn btn-inverse-primary btn-icon-text"
                                        data-bs-toggle="modal" data-bs-target="#filter-ticket">
                                        Filter
                                        <i class="btn-icon-append" data-feather="search"></i>
                                    </button>
                                    <div class="modal fade" id="filter-ticket" tabindex="-1"
                                        aria-labelledby="sourceModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="sourceModalLabel">Filter
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="btn-close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('sorting.ticket') }}" method="post"
                                                        id="sorting">
                                                        @csrf
                                                        <div class="row mb-2">
                                                            <div class="col-md-6 border-end-lg">
                                                                <label for="Choose Partner"
                                                                    class="form-label">Partner</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="filter_prt" id="srt-prt-select">
                                                                    <option value="">- Choose Partner -</option>
                                                                    @foreach ($partner as $item)
                                                                        <option value="{{ $item->partner_id }}"
                                                                            {{ $prt_id == $item->partner_id ? 'selected' : '' }}>
                                                                            {{ $item->partner }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Project</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="filter_prj" id="srt-prj-select">
                                                                    <option value="">- Choose Project -</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <label class="form-label">Schedule</label>
                                                            <div class="col-md-5">
                                                                <div class="mb-3">
                                                                    <div class="input-group flatpickr" id="flatpickr-date">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select Date" name="st_date"
                                                                            id="st-date-mt" value="{{ $val_stDate }}"
                                                                            data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i
                                                                                data-feather="calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 text-center">
                                                                <label class="form-label">s/d</label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="mb-3">
                                                                    <div class="input-group flatpickr" id="flatpickr-date">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="Select Date"
                                                                            value="{{ $val_ndDate }}" name="nd_date"
                                                                            id="nd-date-mt" data-input>
                                                                        <span class="input-group-text input-group-addon"
                                                                            data-toggle><i
                                                                                data-feather="calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-info sort">Sort</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($depart == 4)
                                        <a href="{{ url('helpdesk/form=Ticket') }}">
                                            <button type="button" class="btn btn-inverse-primary btn-icon-text">
                                                New Ticket
                                                <i class="btn-icon-append" data-feather="plus"></i>
                                            </button>
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if ($depart == 10)
                                            <th>Notiket</th>
                                            <th>Project</th>
                                            <th>Service Point</th>
                                        @elseif ($depart == 6 || $depart == 13 || $role == 1)
                                            <th>Notiket</th>
                                            <th>Case ID</th>
                                            <th>Company</th>
                                            <th>SN</th>
                                            <th>Problem</th>
                                            <th>Schedule</th>
                                            <th>Deadline</th>
                                        @elseif ($depart == 9)
                                            <th>Service Point</th>
                                            <th>Notiket</th>
                                            <th>Reference ID</th>
                                            <th>No HP</th>
                                            <th>QTY Part</th>
                                        @else
                                            @if ($depart == 4 || $role == 15 || $depart == 3 || $depart == 5)
                                                <th>No Tiket</th>
                                                <th>Case ID</th>
                                                <th>Schedule</th>
                                                <th>Project</th>
                                                <th>Company</th>
                                                <th>SN</th>
                                                <th>Aging Ticket(Days)</th>
                                                <th>Onsite Ke</th>
                                                <th>Aging Part(Days)</th>
                                                <th>Parts</th>
                                                <th>last update</th>
                                            @endif
                                        @endif
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num = 1;
                                        $now = Carbon::now()->addHours(7);
                                        $date = Carbon::now()
                                            ->addHours(7)
                                            ->format('Y-m-d');
                                    $getDT = TiketPartDetail::select('sub1.part_detail_id', 'sub1.send', 'sub1.arrive', 'sub1.part_onsite')
                                                ->from(function ($query) {
                                                    $query->select(DB::raw('MAX(sub2.id) AS id'))
                                                        ->from(function ($subquery) {
                                                            $subquery->select('htpd.*')
                                                                ->from('hgt_tiket_part_detail as htpd')
                                                                ->leftJoin('hgt_sts_type_part as hstp', 'htpd.type_part', '=', 'hstp.id')
                                                                ->whereRaw('hstp.status = 0');
                                                        }, 'sub2')
                                                        ->groupBy('part_detail_id', 'part_onsite');
                                                }, 'aa')
                                                ->leftJoin('hgt_tiket_part_detail as sub1', 'aa.id', '=', 'sub1.id');
                                    @endphp
                                    @foreach ($ticket as $item)
                                        @php
                                            $part_onsite = in_array($item->status, [0, 1, 9])
                                                                ? 1 
                                                                : ($item->status == 2
                                                                    ? 2
                                                                    : ($item->status == 3
                                                                        ? 3
                                                                        : ($item->status == 4
                                                                            ? 4
                                                                            : 5)));
                                            $getDTForItem = clone $getDT;
                                            $resultDT = $getDTForItem->whereRaw("part_onsite = $part_onsite");

                                            $getPN = TiketPartNew::select('notiket', 'sub3.*')
                                                            ->leftJoin(DB::raw('(' . $resultDT->toSql() . ') sub3'), function ($join) {
                                                                $join->on('hgt_tiket_part_new.part_detail_id', '=', 'sub3.part_detail_id');
                                                            })
                                                            ->whereRaw("notiket = '$item->notiket'")
                                                            ->groupBy('notiket')
                                                            ->first();

                                            $start_date_range = Carbon::parse($item->entrydate);
                                            $end_date_range = Carbon::parse($item->deadline);

                                            $total_days = $start_date_range->diffInDays($end_date_range);

                                            $mail_date = Carbon::parse($item->ticketcoming);
                                            $arrive = Carbon::parse(@$getPN->arrive);

                                            $agingTicket = $mail_date->diffInDays($now);
                                            $agingPart = $arrive->diffInDays($now);

                                            if ($total_days == 0) {
                                                $progress_percentage = 100;
                                            } else {
                                                $days_passed = $start_date_range->diffInDays($now);

                                                $progress_percentage = ($days_passed / $total_days) * 100;
                                            }

                                            $rounded_percentage = round($progress_percentage / 25) * 25;
                                        @endphp
                                        @if ($rounded_percentage > 75)
                                            <tr style="background: rgba(246, 10, 10, 0.1);">
                                            @else
                                            <tr>
                                        @endif
                                        <td>{{ $num }}</td>
                                        @if ($depart == 10)
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->service_name }}</td>
                                        @elseif ($depart == 6 || $depart == 13 || $role == 1)
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->company }}</td>
                                            <td>{{ $item->sn }}</td>
                                            <td>{{ $item->problem }}</td>
                                            <td>{{ $item->departure }}</td>
                                            <td>{{ $item->deadline }}</td>
                                        @elseif ($depart == 9)
                                            <td>{{ $item->service_name }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->total_return }}</td>
                                        @else
                                            @if ($depart == 4 || $role == 15 || $depart == 3 || $depart == 5)
                                                <td>{{ $item->notiket }}</td>
                                                <td>{{ $item->case_id }}</td>
                                                <td>{{ $item->departure }}</td>
                                                <td>{{ $item->project_name }}</td>
                                                <td>{{ $item->company }}</td>
                                                <td>{{ $item->sn }}</td>
                                                <td>
                                                    {{ $agingTicket }}
                                                </td>
                                                <td>{{$item->visiting}}</td>
                                                <td>
                                                    {{ $agingPart }}
                                                </td>
                                                <td>
                                                    {{ $item->sts_part }}
                                                </td>
                                                <td>
                                                    {{ $item->last_update }}
                                                </td>
                                            @endif
                                        @endif
                                        <td>
                                            @if ($depart == 4 || $role == 20 || $role == 15 || $depart == 3 || $depart == 5)
                                                @if ($item->status == 2 && $item->sts_act == 1)
                                                    {{ $item->act_desc == 2
                                                        ? 'On site 2nd : Go to Location'
                                                        : ($item->act_desc == 3
                                                            ? 'On site 2nd : Arrived on location'
                                                            : ($item->act_desc == 4
                                                                ? 'On site 2nd : Start Working'
                                                                : ($item->act_desc == 5
                                                                    ? 'On site 2nd : Stop Working' . $item->solve_en
                                                                    : ($item->act_desc == 6
                                                                        ? 'On site 2nd : Leave Site' . $item->solve_en
                                                                        : ($item->act_desc == 7
                                                                            ? 'On site 2nd : Travel Stop' . $item->solve_en
                                                                            : ''))))) }}
                                                @elseif ($item->status == 3 && $item->sts_act == 2)
                                                    {{ $item->act_desc == 2
                                                        ? 'On site 3rd : Go to Location'
                                                        : ($item->act_desc == 3
                                                            ? 'On site 3rd : Arrived on location'
                                                            : ($item->act_desc == 4
                                                                ? 'On site 3rd : Start Working'
                                                                : ($item->act_desc == 5
                                                                    ? 'On site 3rd : Stop Working' . $item->solve_en
                                                                    : ($item->act_desc == 6
                                                                        ? 'On site 3rd : Leave Site' . $item->solve_en
                                                                        : ($item->act_desc == 7
                                                                            ? 'On site 3rd : Travel Stop' . $item->solve_en
                                                                            : ''))))) }}
                                                @elseif ($item->status == 4 && $item->sts_act == 3)
                                                    {{ $item->act_desc == 2
                                                        ? 'On site 4th : Go to Location'
                                                        : ($item->act_desc == 3
                                                            ? 'On site 4th : Arrived on location'
                                                            : ($item->act_desc == 4
                                                                ? 'On site 4th : Start Working'
                                                                : ($item->act_desc == 5
                                                                    ? 'On site 4th : Stop Working' . $item->solve_en
                                                                    : ($item->act_desc == 6
                                                                        ? 'On site 4th : Leave Site' . $item->solve_en
                                                                        : ($item->act_desc == 7
                                                                            ? 'On site 4th : Travel Stop' . $item->solve_en
                                                                            : ''))))) }}
                                                @elseif ($item->status == 5 && $item->sts_act == 4)
                                                    {{ $item->act_desc == 2
                                                        ? 'On site 5th : Go to Location'
                                                        : ($item->act_desc == 3
                                                            ? 'On site 5th : Arrived on location'
                                                            : ($item->act_desc == 4
                                                                ? 'On site 5th : Start Working'
                                                                : ($item->act_desc == 5
                                                                    ? 'On site 5th : Stop Working' . $item->solve_en
                                                                    : ($item->act_desc == 6
                                                                        ? 'On site 5th : Leave Site' . $item->solve_en
                                                                        : ($item->act_desc == 7
                                                                            ? 'On site 5th : Travel Stop' . $item->solve_en
                                                                            : ''))))) }}
                                                @else
                                                    {{ $item->dtStatus . ' ' . $item->solve_en }}
                                                @endif
                                            @elseif ($depart == 9)
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
                                            @elseif ($depart == 6 || $role == 1)
                                                {{ $item->status == 9
                                                    ? 'Need to Receive'
                                                    : ($item->status == 5
                                                        ? 'Solved'
                                                        : ($item->status == 2 || $item->status == 3
                                                            ? ($item->reqsCek == 1
                                                                ? 'Pending : waiting for the component to be ready by helpdesk'
                                                                : 'Open')
                                                            : 'Progress Activity')) }}
                                            @elseif ($depart == 13)
                                                {{ $item->status == 9 ? 'Waiting Engineer to Submit Activity' : 'Update your Activity' }}
                                            @elseif ($depart == 10)
                                                {{ $item->status_docs == 0 ? 'Documents isn\'t received' : 'Documents received' }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-toolbar" role="toolbar"
                                                aria-label="Toolbar with button groups">
                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                    @php
                                                        if ($depart == 13) {
                                                            $url = "Update/L2-Engineer/$item->notiket/Ticket";
                                                        } else {
                                                            $url = "Update/$item->notiket/Engineer-Ticket";
                                                        }
                                                    @endphp
                                                    <form action="{{ url("$url") }}"
                                                        id="updt-en-ticket{{ $num }}" method="post">
                                                        @csrf
                                                        @if ($depart != 13)
                                                            {{ method_field('patch') }}
                                                        @endif
                                                        <input type="hidden" id="latitude{{ $num }}"
                                                            name="latitude">
                                                        <input type="hidden" id="longitude{{ $num }}"
                                                            name="longitude">
                                                    </form>
                                                    @if ($depart == 6 || $role == 1)
                                                        @php
                                                            $valid_reqs = RefReqs::where('notiket', $item->notiket)->first();
                                                            if (!empty(@$valid_reqs->get_reqs->en_id)) {
                                                                if (@$valid_reqs->get_reqs->en_id == $nik) {
                                                                    $bool = false;
                                                                } else {
                                                                    $bool = true;
                                                                }
                                                            }else{
                                                                $bool = true;
                                                            }
                                                        @endphp
                                                        @if ($bool)
                                                            <a href="{{ url("Add/Reqs-Accomodation/$item->notiket") }}"
                                                                class="btn btn-inverse-info btn-icon btn-sm">
                                                                <i data-feather="credit-card"></i>
                                                            </a>
                                                            {{@$valid_reqs->get_reqs->en_id}}
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-inverse-danger btn-icon btn-sm"
                                                                data-bs-toggle="popover" title="This Ticket already have a Request!"
                                                                data-bs-content="create a new one? <a href='{{ url("Add/Reqs-Accomodation/$item->notiket") }}'>ADD </a> or Want to visit it? <a href='{{ url('/My-Expenses') }}'>Visit!"><i
                                                                    data-feather="credit-card"></i></button>
                                                        @endif
                                                        &nbsp;
                                                        @if ($item->status == 9)
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm updt-en-ticket{{ $num }}">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                            &nbsp;
                                                        @elseif (!in_array($item->status, [0, 9]))
                                                            <a
                                                                href="{{ url("Timeline/Engineer/Ticket=$item->notiket") }}">
                                                                <button type="button"
                                                                    class="btn btn-inverse-info btn-icon btn-sm">
                                                                    <i data-feather="activity"></i>
                                                                </button>
                                                            </a>
                                                            &nbsp;
                                                        @endif
                                                    @elseif ($depart == 13)
                                                        @php
                                                            $vald_act_l2 = ActivityL2En::where('notiket', $item->notiket)->first();
                                                        @endphp
                                                        @if ($date == Carbon::parse($item->departure)->format('Y-m-d'))
                                                            @if (empty($vald_act_l2) && ($item->status > 0 && $item->status < 9))
                                                                <button type="button"
                                                                    class="btn btn-inverse-info btn-icon btn-sm updt-en-ticket{{ $num }}">
                                                                    <i data-feather="edit"></i>
                                                                </button>
                                                                &nbsp;
                                                            @elseif ($item->status != 9)
                                                                <a
                                                                    href="{{ url("Timeline/L2-Engineer/Ticket=$item->notiket") }}">
                                                                    <button type="button"
                                                                        class="btn btn-inverse-info btn-icon btn-sm">
                                                                        <i data-feather="activity"></i>
                                                                    </button>
                                                                </a>
                                                                &nbsp;
                                                            @endif
                                                        @endif
                                                    @elseif ($depart == 4)
                                                        @if (!empty($item->solve_en))
                                                            @if ($item->status < 10 && $item->act_desc == 7)
                                                                <button type="button"
                                                                    class="btn btn-inverse-secondary btn-icon btn-sm updt-en-ticket{{ $num }}">
                                                                    <i data-feather="check"></i>
                                                                </button>
                                                                &nbsp;
                                                            @endif
                                                        @endif
                                                        @if ($role == 19)
                                                            <form action="{{ url("Remove/$item->notiket/Ticket-HGT") }}"
                                                                id="form-remove-ticket{{ $num }}"
                                                                method="post">
                                                                @csrf
                                                                {{ method_field('delete') }}
                                                            </form>
                                                            <button type="button"
                                                                class="btn btn-inverse-danger btn-icon btn-sm btn-remove-ticket{{ $num }}">
                                                                <i data-feather="trash-2"></i>
                                                            </button>
                                                            &nbsp;
                                                        @endif
                                                        @if (in_array($item->status, array_slice($ar_sts, 1)))
                                                            @if ($item->reqsCek == 1)
                                                                <form
                                                                    action="{{ url("Fulfilled/Part-Reqs/$item->notiket") }}"
                                                                    id="form-part-ready-foren{{ $num }}"
                                                                    method="post">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                </form>
                                                                <button type="button"
                                                                    class="btn btn-inverse-primary btn-icon btn-sm btn-part-ready-ornot{{ $num }}">
                                                                    <i data-feather="check"></i>
                                                                </button>
                                                                &nbsp;
                                                            @endif
                                                        @endif
                                                    @elseif ($depart == 9)
                                                        @if ($item->status_awb == 0)
                                                            <a href="{{ url("Ticket/AWB/Update=$item->notiket") }}">
                                                                <button type="button"
                                                                    class="btn btn-inverse-primary btn-icon btn-sm">
                                                                    <i data-feather="file"></i>
                                                                </button>
                                                            </a>
                                                            &nbsp;
                                                        @endif
                                                    @elseif ($depart == 10)
                                                        @if ($item->status_docs == 0)
                                                            <button type="button"
                                                                class="btn btn-inverse-primary btn-icon btn-sm btn-receive-docs{{ $num }}">
                                                                <i data-feather="check"></i>
                                                            </button>
                                                            <form action="{{ url("Update-Ticket/Docs/$item->notiket") }}"
                                                                id="receive-docs{{ $num }}"
                                                                style="display: none;" method="post">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                            </form>
                                                            &nbsp;
                                                        @endif
                                                    @endif
                                                    <a href="{{ url("Detail/Ticket=$item->notiket") }}">
                                                        <button type="button"
                                                            class="btn btn-inverse-success btn-icon btn-sm ">
                                                            <i data-feather="search"></i>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        </tr>
                                        @php
                                            $num++;
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> --}}
@endpush
@push('custom-plug')
@endpush
@push('custom')
    @if ($depart == 6 || $depart == 13 || $role == 1)
        <script>
            var dept = {{ $depart }};
            if (dept == 13) {
                var title = "Stand By?";
            } else {
                var title = "Receive Ticket??";
            }
            for (let i = 0; i < 1000; i++) {
                $('.updt-en-ticket' + i).on('click', function() {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        document.getElementById('latitude' + i).value = lat;
                        document.getElementById('longitude' + i).value = lng;
                    }, function(error) {
                        console.log("Error occurred. Error code: " + error.code);
                    });

                    Swal.fire({
                        title: title,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#updt-en-ticket' + i).submit();
                        }
                    });
                });
            }
        </script>
    @elseif ($depart == 4 || $role == 20 || $role == 15)
        <script>
            for (let i = 0; i < 1000; i++) {
                $('.updt-en-ticket' + i + '').on('click', function() {
                    var getLink = $(this).attr('href');
                    Swal.fire({
                        title: 'Close Ticket?',
                        text: 'Ticket will be closed!',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getLink;
                            jQuery('#updt-en-ticket' + i + '').submit();
                        }
                    });
                    return false;
                });
                $('.btn-part-ready-ornot' + i + '').on('click', function() {
                    var getLink = $(this).attr('href');
                    Swal.fire({
                        title: 'Part Its ready?',
                        text: 'please check the part list again, is it the part requested by the engineer!',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Complete',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getLink;
                            jQuery('#form-part-ready-foren' + i + '').submit();
                        }
                    });
                    return false;
                });

                $('.btn-remove-ticket' + i + '').on('click', function() {
                    Swal.fire({
                        title: 'Are u sure delete this Ticket?',
                        text: 'Ticket will be deleted permanently!!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Yes',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            jQuery('#form-remove-ticket' + i + '').submit();
                        }
                    });
                    return false;
                });
            }
        </script>
        <script>
            function getProjectSrt(url, prt_id, project) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        prt_id: prt_id
                    },
                    success: function(data) {
                        if (data.length === 0) {
                            $('#' + project).empty();
                            $('#' + project).append(
                                '<option value="">- No Project found for the selected Partner -</option>');
                        } else {
                            $('#' + project).empty();
                            $('#' + project).append('<option value="">- Choose -</option>');
                            $.each(data, function(key, value) {
                                selected = '';
                                if ('{{ $prj_id }}' ==
                                    key) {
                                    selected = 'selected';
                                }
                                $('#' + project).append('<option value="' + key + '" ' + selected + '>' +
                                    value + '</option>');
                            });
                        }
                    }
                });
            }

            $(function() {
                var partnerSelect = $('#srt-prt-select');
                var projectSelect = $('#srt-prj-select');
                var selectedPartner = '{{ $prt_id }}';

                if (selectedPartner !== '') {
                    partnerSelect.val(selectedPartner);
                    getProjectSrt('{{ route('GetdtProject') }}', partnerSelect.val(), 'srt-prj-select');
                } else {
                    projectSelect.empty();
                    projectSelect.append('<option value="">- Select Partner First -</option>');
                }

                partnerSelect.on('change', function() {
                    var selectedPartnerId = $(this).val();
                    if (selectedPartnerId === '') {
                        projectSelect.empty();
                        projectSelect.append('<option value="">- Choose -</option>');
                    } else {
                        getProjectSrt('{{ route('GetdtProject') }}', selectedPartnerId, 'srt-prj-select');
                    }
                });
            });
        </script>
    @elseif ($depart == 10)
        <script>
            for (let i = 0; i < 9999; i++) {
                $('.btn-receive-docs' + i + '').on('click', function() {
                    var getLink = $(this).attr('href');
                    Swal.fire({
                        title: 'Documents its received?',
                        text: 'This ticket will be updated the docs its received!',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: 'Next',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = getLink;
                            jQuery('#receive-docs' + i + '').submit();
                        }
                    });
                    return false;
                });
            }
        </script>
    @endif
    <script>
        $('.sort').on('click', function() {
            let st_date = document.getElementById("st-date-mt").value;
            let nd_date = document.getElementById("nd-date-mt").value;

            if (st_date == "" && nd_date != "") {
                Swal.fire({
                    title: 'Your sort first date is null!',
                    icon: 'warning',
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'OK',
                });
                return false;
            } else if (st_date != "" && nd_date == "") {
                Swal.fire({
                    title: 'Your sort second date is null!',
                    icon: 'warning',
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'OK',
                });
                return false;
            } else {
                jQuery('#sorting').submit();
            }
        });
    </script>
@endpush
