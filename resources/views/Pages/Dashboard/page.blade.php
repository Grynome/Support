@push('css-plugin')
@endpush
@extends('Theme.Full-Dash.header')
@section('full-Dash')
    <div class="page-content">
        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0">Total Ticket</h6>
                                        </div>
                                        <h3 class="mb-2 ticket-today text-center">
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0">On Progress</h6>
                                        </div>
                                        <h3 class="mb-2 prog-pen-ticket text-center"></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-12 col-xl-12">
                                        <div class="d-flex justify-content-between align-items-baseline mb-3">
                                            <h6 class="card-title mb-0">Close Ticket</h6>
                                        </div>
                                        <h3 class="mb-2 close-today text-center">
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->

        <div class="row">
            <div class="col-lg-12 col-xl-12 stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="example">
                            <div class="perfect-scrollbar-example p-custom border">
                                <div class="table-responsive">
                                    <table id="tblDash" class="table table-hover mb-0 progress-ticket-table">
                                        <thead class="head-of">
                                            <tr>
                                                <th>No Tiket</th>
                                                <th class="dvc">Case ID</th>
                                                <th>Project</th>
                                                <th>Company</th>
                                                <th>Lokasi</th>
                                                <th>Nama FE</th>
                                                <th>Status</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/apexcharts/apexcharts.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/dashboard-light.js"></script>
@endpush
@push('custom')
    <script>
        (function($) {
            'use strict';
            $(function() {
                if ($('.perfect-scrollbar-example').length) {
                    var scrollbarExample = new PerfectScrollbar('.perfect-scrollbar-example');
                }

            });
        })(jQuery);
    </script>
    <script>
        $(document).ready(function() {
            const container = document.querySelector('.perfect-scrollbar-example');
            let scrollPosition = container.scrollTop;
            let isMouseOver = false;

            container.addEventListener('mouseover', function() {
                isMouseOver = true;
            });

            container.addEventListener('mouseout', function() {
                isMouseOver = false;
            });

            const tableHeader = document.querySelector('#tblDash thead');

            function scrollToEndAndRepeat() {
                const maxScrollHeight = container.scrollHeight - container.clientHeight;
                const scrollIncrement = 1;

                if (!isMouseOver) {
                    scrollPosition = (scrollPosition + 2) % (maxScrollHeight + 2);
                    container.scrollTop = scrollPosition;

                    if (scrollPosition === maxScrollHeight) {
                        scrollPosition = 0;
                    }
                }
                
                if (scrollPosition > 0) {
                    tableHeader.style.transform = `translateY(${container.scrollTop}px)`;
                } else {
                    tableHeader.style.transform = 'none';
                }

                setTimeout(() => {
                    requestAnimationFrame(scrollToEndAndRepeat);
                }, 150);
            }

            function fetchTicketData() {
                $.ajax({
                    url: 'get-tickets/',
                    dataType: 'json',
                    success: function(data) {
                        if (data.length === 0) {
                            var noDataRow =
                                '<tr><td colspan="9" class="no-data-caption">No data available in table</td></tr>';
                            $('.progress-ticket-table tbody').html(noDataRow);
                            return;
                        } else {
                            var num = 1;
                            var tableRows = '';
                            $.each(data, function(index, item) {
                                tableRows += '<tr>';
                                tableRows += '<td class="tx-9">' + item.notiket + '</td>';
                                tableRows += '<td class="dvc tx-9">' + item.case_id + '</td>';
                                tableRows += '<td class="tx-9">' + item.project_name + '</td>';
                                tableRows += '<td class="tx-9">' + item.company + '</td>';
                                tableRows += '<td class="tx-9">' + item.lok_kab + '</td>';
                                tableRows += '<td class="tx-9">' + item.full_name + '</td>';
                                tableRows +=
                                    '<td class=""><span class="status-dash" data-tiket-id="' +
                                    item
                                    .tiket_id +
                                    '">Loading...</span></td>';
                                tableRows +=
                                    '<td class=""><span class="act-time" data-tiket-id="' +
                                    item
                                    .tiket_id +
                                    '">Loading...</span></td>';
                                tableRows += '</tr>';
                                num++;
                            });
                            $('.progress-ticket-table tbody').html(tableRows);
                            fetchTicketStatus();
                        }
                    },
                    error: function() {
                        console.log('Failed to fetch ticket data.');
                    }
                });
            }

            function fetchTicketStatus() {
                var statusSpans = $('span.status-dash');
                statusSpans.each(function() {
                    var statusSpan = $(this);
                    var itemId = statusSpan.data('tiket-id');
                    $.ajax({
                        url: 'status/' + itemId,
                        dataType: 'json',
                        success: function(response) {
                            updateStatusDash(
                                itemId,
                                response.status,
                                response.act_descriptionst,
                                response.status_activityst,
                                response.act_timest,
                                response.act_descriptionnd,
                                response.status_activitynd,
                                response.act_timend,
                                response.act_descriptionrd,
                                response.status_activityrd,
                                response.act_timerd,
                                response.pending,
                                response.act_timepending,
                                response.solve);
                        },
                        error: function() {
                            console.log('Failed to fetch status for ticket ID ' + itemId);
                        }
                    });
                });
            }

            function updateStatusDash(
                itemId,
                status,
                act_descriptionst,
                status_activityst,
                act_timest,
                act_descriptionnd,
                status_activitynd,
                act_timend,
                act_descriptionrd,
                status_activityrd,
                act_timerd,
                pending,
                act_timepending,
                solve) {
                var statusSpanDash = $('span.status-dash[data-tiket-id="' + itemId + '"]');
                var act_timeDash = $('span.act-time[data-tiket-id="' + itemId + '"]');

                statusSpanDash.removeClass().addClass('status-dash badge rounded-pill');
                if (!solve === 0) {
                    var ket = '';
                } else {
                    var ket = '(Solved)';
                }
                if (status == 0) {
                    statusSpanDash.addClass('bg-info').text('Pending (Ticket not Ready)');
                    act_timeDash.text('-');
                } else if (status == 9) {
                    statusSpanDash.addClass('bg-info').text('Pending (Sending to Engineer)');
                    act_timeDash.text('-');
                } else if (status == 1) {
                    if (act_descriptionst == 1) {
                        statusSpanDash.addClass('bg-info').text('Received Ticket');
                    } else if (act_descriptionst == 2) {
                        statusSpanDash.addClass('bg-info').text('Go to Location');
                    } else if (act_descriptionst == 3) {
                        statusSpanDash.addClass('bg-info').text('Arrived on location');
                    } else if (act_descriptionst == 4) {
                        statusSpanDash.addClass('bg-info').text('Start Working');
                    } else if (act_descriptionst == 5) {
                        statusSpanDash.addClass('bg-info').text('Stop Working' + ' ' + ket);
                    } else if (act_descriptionst == 6) {
                        statusSpanDash.addClass('bg-info').text('Leave Site' + ' ' + ket);
                    } else if (act_descriptionst == 7) {
                        statusSpanDash.addClass('bg-info').text('Travel Stop' + ' ' + ket);
                    }
                    act_timeDash.text(act_timest);
                } else if (status == 2 && (act_descriptionnd !== null && status_activitynd !== null) &&
                    status_activityst == 0) {
                    if (act_descriptionnd == 2) {
                        statusSpanDash.addClass('bg-info').text('On site 2nd : Go to Location');
                    } else if (act_descriptionnd == 3) {
                        statusSpanDash.addClass('bg-info').text('On site 2nd : Arrived on location');
                    } else if (act_descriptionnd == 4) {
                        statusSpanDash.addClass('bg-info').text('On site 2nd : Start Working');
                    } else if (act_descriptionnd == 5) {
                        statusSpanDash.addClass('bg-info').text('On site 2nd : Stop Working' + ' ' + ket);
                    } else if (act_descriptionnd == 6) {
                        statusSpanDash.addClass('bg-info').text('On site 2nd : Leave Site' + ' ' + ket);
                    } else if (act_descriptionnd == 7) {
                        statusSpanDash.addClass('bg-info').text('On site 2nd : Travel Stop' + ' ' + ket);
                    }
                    act_timeDash.text(act_timend);
                } else if (status == 3 && (act_descriptionrd !== null && status_activityrd !== null) &&
                    status_activitynd == 0) {
                    if (act_descriptionrd == 2) {
                        statusSpanDash.addClass('bg-info').text('On site 3rd : Go to Location');
                    } else if (act_descriptionrd == 3) {
                        statusSpanDash.addClass('bg-info').text('On site 3rd : Arrived on location');
                    } else if (act_descriptionrd == 4) {
                        statusSpanDash.addClass('bg-info').text('On site 3rd : Start Working');
                    } else if (act_descriptionrd == 5) {
                        statusSpanDash.addClass('bg-info').text('On site 3rd : Stop Working' + ' ' + ket);
                    } else if (act_descriptionrd == 6) {
                        statusSpanDash.addClass('bg-info').text('On site 3rd : Leave Site' + ' ' + ket);
                    } else if (act_descriptionrd == 7) {
                        statusSpanDash.addClass('bg-info').text('On site 3rd : Travel Stop' + ' ' + ket);
                    }
                    act_timeDash.text(act_timerd);
                } else if ((status == 2 || status == 3) && (!pending || pending !== null)) {
                    if (!pending) {
                        if (status == 2) {
                            statusSpanDash.addClass('bg-warning').text('Pending : 1st(Engineer Need Part)');
                        } else if (status == 3) {
                            statusSpanDash.addClass('bg-warning').text('Pending : 2nd(Engineer Need Part)');
                        } else if (status == 4) {
                            statusSpanDash.addClass('bg-warning').text('Pending : 3rd(Engineer Need Part)');
                        } else if (status == 5) {
                            statusSpanDash.addClass('bg-warning').text('Pending : 4th(Engineer Need Part)');
                        }
                        act_timeDash.text(act_timepending);
                    } else if (pending !== null) {
                        if (status == 2) {
                            statusSpanDash.addClass('bg-warning').text(
                                'Pending : waiting engineer continue 2nd Onsite');
                        } else {
                            statusSpanDash.addClass('bg-warning').text(
                                'Pending : waiting engineer continue 3rd Onsite)');
                        }
                        var datePending = new Date(pending);
                        var options = {
                            hour: '2-digit',
                            minute: '2-digit',
                            timeZone: 'UTC'
                        };
                        var formattedTime = datePending.toLocaleTimeString([], options);
                        act_timeDash.text(formattedTime);
                    }
                }
            }
            // Ticket Today
            function updateTicketData() {
                $.ajax({
                    url: 'ticketsToday/',
                    dataType: 'json',
                    success: function(data) {
                        $('h3.mb-2.ticket-today').text(data.today_ticket);
                        $('h3.mb-2.close-today').text(data.num_close);
                        $('h3.mb-2.prog-pen-ticket').text(data.progpen);
                    },
                    error: function() {
                        alert('Error occurred while getting ticket data.');
                    }
                });
            }

            setInterval(fetchTicketData, 20000);
            setInterval(updateTicketData, 20000);
            scrollToEndAndRepeat();
        });
    </script>
@endpush
