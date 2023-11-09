@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('Report/data=KPI-User') }}">Data Report Ticket</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detil Report Data</li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Data Part</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table partData">
                                        <thead>
                                            <tr>
                                                <th>unit_name</th>
                                                <th>so_num</th>
                                                <th>awb_num</th>
                                                <th>rma</th>
                                                <th>sn</th>
                                                <th>pn</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
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
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h4 class="card-title">Log Note Helpdesk</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table noteData">
                                        <thead>
                                            <tr>
                                                <th>ktgr_name</th>
                                                <th>note</th>
                                                <th>full_name</th>
                                                <th>created_at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom')
    <script>
        $(document).ready(function() {
            var notiket = '{{ $id }}';
            var baseUrl = '{{ url('/') }}';

            $.ajax({
                url: baseUrl + '/' + 'getAjaxDetil/' + notiket,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    populateTable('.partData', data.query_part, ['unit_name', 'so_num', 'awb_num',
                        'rma', 'sn', 'pn', 'part_type'
                    ]);
                    populateTable('.noteData', data.query_note, ['ktgr_name', 'note', 'full_name',
                        'created_at'
                    ]);
                    // Initialize DataTable for each table
                    $('.partData').DataTable({
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                    });
                    $('.noteData').DataTable({
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            function populateTable(tableClass, items, columns) {
                var table = $(tableClass + ' tbody');
                table.empty();

                if (items && items.length > 0) {
                    items.forEach(function(item) {
                        var rowHtml = '<tr>';
                        columns.forEach(function(column) {
                            if (column === 'created_at') {
                                var isoDate = item[column];
                                var date = new Date(isoDate);
                                var formattedDate = date.toISOString().slice(0, 19).replace('T',
                                    ' ');
                                rowHtml += '<td>' + formattedDate + '</td>';
                            } else {
                                rowHtml += '<td>' + item[column] + '</td>';
                            }
                        });
                        rowHtml += '</tr>';
                        table.append(rowHtml);
                    });
                }
            }
        });
    </script>
@endpush
