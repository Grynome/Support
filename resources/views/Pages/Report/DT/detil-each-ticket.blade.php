@extends('Theme/header')
@php
    use App\Models\VW_Act_Heldepsk;
@endphp
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report - History Ticket</li>
            </ol>
        </nav>
        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                @if (!preg_match('/Week/', $timeframe))
                                    <h4 class="card-title">Detil Pending Each Month
                                    </h4>
                                    <h3>{{ $timeframe . ' - ' . $year }}
                                    </h3>
                                @else
                                    <h4 class="card-title">Detil Pending Each Week
                                    </h4>
                                    <h3>{{ $timeframe . ' - ' . $month . ' - ' . $year }}
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
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Notiket</th>
                                        <th>Case ID</th>
                                        <th>Project</th>
                                        <th>Company</th>
                                        <th>Entry Date</th>
                                        <th>Service Point</th>
                                        <th>Description</th>
                                        <th>Pending</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($pending as $item)
                                        @php
                                            $fetchNote = VW_Act_Heldepsk::where('notiket', $item->notiket)
                                                ->get();
                                        @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->notiket }}</td>
                                            <td>{{ $item->case_id }}</td>
                                            <td>{{ $item->project_name }}</td>
                                            <td>{{ $item->end_user_name }}</td>
                                            <td>{{ $item->entrydate }}</td>
                                            <td>{{ $item->service_name }}</td>
                                            <td>{{ $item->note }}</td>
                                            <td>
                                                @php
                                                    $get_stsPD = $item->ktgr_pending;

                                                    switch ($get_stsPD) {
                                                    case 1:
                                                        echo "User!";
                                                        break;
                                                    case 2:
                                                        echo "Engineer!";
                                                        break;
                                                    case 3:
                                                        echo "Helpdesk!";
                                                        break;
                                                    case 4:
                                                        echo "Part!";
                                                        break;
                                                    default:
                                                        echo "No pending status";
                                                    }
                                                @endphp
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark btn-icon btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#dtNote{{$no}}">
                                                    Note
                                                </button>
                                                <div class="modal fade bd-example-modal-lg" id="dtNote{{$no}}" tabindex="-1"
                                                    aria-labelledby="sourceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="sourceModalLabel">Data Note
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
                                                                                <th>User</th>
                                                                                <th>Category</th>
                                                                                <th>Note</th>
                                                                                <th>Time Frame</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @php
                                                                                $num = 1;
                                                                            @endphp
                                                                            @foreach ($fetchNote as $item)
                                                                            <tr>
                                                                                <td>{{$num}}</td>
                                                                                <td>{{$item->full_name}}</td>
                                                                                <td>{{$item->ktgr_note}}</td>
                                                                                <td>{{$item->note}}</td>
                                                                                <td>{{$item->created_at}}</td>
                                                                            </tr>
                                                                            @php
                                                                                $num++;
                                                                            @endphp
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