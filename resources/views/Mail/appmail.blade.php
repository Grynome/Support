@push('css-plugin')
@endpush
@extends('Theme.Full-Dash.header')
@section('full-Dash')
    <div class="page-content" style="background-color: #f2f2f2;">
        <div class="row">
            <div class="col-md-12">
                <div class="bg" style="background-color: rgb(19, 18, 18)">
                    <center>
                        <h1><b>App Task</b></h1>
                    </center>
                </div>
                <div class="d-flex align-items-center" style="border-bottom: double;">
                    <h2>Detail Ticket</h2>
                </div>
                <div class="table-responsive" style="margin-bottom: 60px;">
                    <table class="table" style="width: 100%">
                        <tbody>
                            <tr>
                                <td style="width: 15%;">No Tiket</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->notiket }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Case ID</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->case_id }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">SLA</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->sla_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Entry Date</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->entrydate }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Email Masuk</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->ticketcoming }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Deadline</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->deadline }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Close Date</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->closedate }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Souce</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->sumber_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Project</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->project_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Partner</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->partner }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Customer</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->contact_person }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Company</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->company }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">phone</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->phone }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">email</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->email }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Alamat</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->address }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Location</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->severity_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Solution</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->action_plan }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Problem</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->problem }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Unit</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->category_name." / ".$ticket->merk." / ".$ticket->type_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Serial Number</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->sn }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Product Number</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->pn }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Warranty</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->garansi }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Part Request</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->part_request }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Service Point</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->service_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Engineer</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->full_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Schedule</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->departure }}</td>
                            </tr>
                            <tr>
                                <td style="width: 15%;">Status</td>
                                <td style="width: 2%;">=</td>
                                <td style="width: 83%;">{{ $ticket->dtStatus }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table" style="width: 100%">
                        <thead style="background-color: rgb(19, 18, 18);">
                            <tr>
                                <th>No</th>
                                <th>Created At</th>
                                <th>Note</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $num = 1;
                            @endphp
                            @foreach ($note as $data)
                                <tr>
                                    <td>{{ $num++ }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    <td>{{ $data->note }}</td>
                                    <td>{{ $data->full_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/apexcharts/apexcharts.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/dashboard-light.js"></script>
@endpush
