@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
@endpush
@php
    use App\Models\VW_Activity_Engineer;
    use App\Models\ActivityEngineer;
    use App\Models\VW_Tiket_Part;
    use Carbon\Carbon;
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Manage Ticket</li>
                <li class="breadcrumb-item active" aria-current="page">Ticket Today</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <h6 class="card-title">Ticket Today</h6>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Tiket</th>
                                        <th>Case ID</th>
                                        <th>Schedule</th>
                                        <th>Project</th>
                                        <th>Company</th>
                                        <th>SN</th>
                                        <th>Completeness</th>
                                        <th>INTERVAL</th>
                                        <th>TIMEOUT</th>
                                        <th>last update</th>
                                        <th>Status</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num = 1;
                                    @endphp
                                    @foreach ($ticket as $item)
                                        @php
                                            $now = Carbon::now();
                                            $plan = Carbon::parse($item->departure);
                                            if ($now > $plan) {
                                                $selisih = "Overdue";
                                            }else{
                                                $selisih = 'H-'.$now->diffInDays($plan);
                                            }
                                            $datenow = Carbon::now()->addHours(7);
                                            $start_date_range = Carbon::parse($item->entrydate);
                                            $end_date_range = Carbon::parse($item->deadline);
                                            
                                            $total_days = $start_date_range->diffInDays($end_date_range);
                                            
                                            if ($total_days == 0) {
                                                $progress_percentage = 100;
                                            } else {
                                                $days_passed = $start_date_range->diffInDays($datenow);
                                            
                                                $progress_percentage = ($days_passed / $total_days) * 100;
                                            }
                                            
                                            $rounded_percentage = round($progress_percentage / 25) * 25;
                                            
                                            if ($rounded_percentage < 25) {
                                                $progress_width = '25%';
                                                $progress_level = '25';
                                            } elseif ($rounded_percentage <= 50) {
                                                $progress_width = '50%';
                                                $progress_level = '50';
                                            } elseif ($rounded_percentage <= 75) {
                                                $progress_width = '75%';
                                                $progress_level = '75';
                                            } else {
                                                $progress_width = '100%';
                                                $progress_level = '100';
                                            }
                                            if ($rounded_percentage < 25) {
                                                $progress_color = 'bg-success';
                                                $animated = 'progress-bar-striped progress-bar-animated';
                                            } elseif ($rounded_percentage <= 50) {
                                                $progress_color = 'bg-gradient-middle';
                                                $animated = '';
                                            } elseif ($rounded_percentage <= 75) {
                                                $progress_color = 'bg-gradient-almost';
                                                $animated = '';
                                            } else {
                                                $progress_color = 'bg-danger';
                                                $animated = 'progress-bar-striped progress-bar-animated';
                                            }
                                        @endphp
                                @if ($rounded_percentage > 75)
                                    <tr style="background: rgba(246, 10, 10, 0.1);">
                                @else
                                    <tr>
                                @endif
                                        <td>{{ $num }}</td>
                                        <td>{{ $item->notiket }}</td>
                                        <td>{{ $item->case_id }}</td>
                                        <td>{{ $item->departure }}</td>
                                        <td>{{ $item->project_name }}</td>
                                        <td>{{ $item->company }}</td>
                                        <td>{{ $item->sn }}</td>
                                        <td>
                                            @if (empty($item->completeness))
                                                Part not Added
                                            @else
                                                {{ $item->completeness }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $selisih }}
                                        </td>
                                        <td>
                                            @if ($item->status != 10)
                                                <div class="progress">
                                                    <div class="progress-bar {{ $progress_color }} {{ $animated }}"
                                                        role="progressbar" style="width: {{ $progress_width }};"
                                                        aria-valuenow="{{ $progress_level }}" aria-valuemin="0"
                                                        aria-valuemax="100">{{ $progress_level }}%</div>
                                                </div>
                                            @else
                                                Done
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->last_update }}
                                        </td>
                                        <td>
                                            @if ($item->status == 2 && $item->sts_act == 1)
                                                @if ($item->act_desc == 2)
                                                    On site 2nd : Go to Location
                                                @elseif ($item->act_desc == 3)
                                                    On site 2nd : Arrived on location
                                                @elseif ($item->act_desc == 4)
                                                    On site 2nd : Start Working
                                                @elseif ($item->act_desc == 5)
                                                    On site 2nd : Stop Working
                                                    {{ $item->solve_en }}
                                                @elseif ($item->act_desc == 6)
                                                    On site 2nd : Leave Site
                                                    {{ $item->solve_en }}
                                                @elseif ($item->act_desc == 7)
                                                    On site 2nd : Travel Stop
                                                    {{ $item->solve_en }}
                                                @endif
                                            @elseif ($item->status == 3 && $item->sts_act == 2)
                                                @if ($item->act_desc == 2)
                                                    On site 3rd : Go to Location
                                                @elseif ($item->act_desc == 3)
                                                    On site 3rd : Arrived on location
                                                @elseif ($item->act_desc == 4)
                                                    On site 3rd : Start Working
                                                @elseif ($item->act_desc == 5)
                                                    On site 3rd : Stop Working
                                                    {{ $item->solve_en }}
                                                @elseif ($item->act_desc == 6)
                                                    On site 3rd : Leave Site
                                                    {{ $item->solve_en }}
                                                @elseif ($item->act_desc == 7)
                                                    On site 3rd : Travel Stop
                                                    {{ $item->solve_en }}
                                                @endif
                                            @else
                                                {{ $item->dtStatus.' '.$item->solve_en }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group me-2" role="group" aria-label="First group">
                                                    <form action="{{ url("Update/$item->notiket/Engineer-Ticket") }}"
                                                        id="updt-en-ticket{{ $num }}" method="post">
                                                        @csrf
                                                        {{ method_field('patch') }}
                                                    </form>
                                                    @if (!empty($item->solve_en))
                                                        @if ($item->status < 10 && $item->act_desc == 7)
                                                            <button type="button"
                                                                class="btn btn-inverse-secondary btn-icon btn-sm updt-en-ticket{{ $num }}">
                                                                <i data-feather="check"></i>
                                                            </button>
                                                            &nbsp;
                                                        @endif
                                                    @endif
                                                    @if ($item->status == 2 || $item->status == 3)
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
@push('custom')
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
@endpush