@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
    $noTabs = 0;
    $noPane = 0;
    $tabs = [1, 2, 3, 4, 5];
@endphp
@if ($sts_timeline1st->status_activity == 1)
    @php
        $activest = 'active';
        $activend = '';
        $activerd = '';
        $active4th = '';
        $active5th = '';
        $txt = '1st On Site (Activity Uncomplete)';
        $txt2nd = '2nd On Site';
        $txt3rd = '3rd On Site';
        $txt4th = '4th On Site';
        $txt5th = '5th On Site';
    @endphp
@elseif (@$sts_timeline2nd->status_activity == 1)
    @php
        if ($status_ticket->status == 1) {
            $activest = 'active';
        } else {
            $activest = '';
        }
        $activend = 'active';
        $activerd = '';
        $active4th = '';
        $active5th = '';
        $txt = '1st On Site';
        $txt2nd = '2nd On Site (Activity Uncomplete)';
        $txt3rd = '3rd On Site';
        $txt4th = '4th On Site';
        $txt5th = '5th On Site';
    @endphp
@elseif (@$sts_timeline3rd->status_activity == 1)
    @php
        $activest = '';
        $txt = '1st On Site';
        if ($status_ticket->status == 2) {
            $activend = 'active';
        } else {
            $activend = '';
        }
        $activerd = 'active';
        $active4th = '';
        $active5th = '';
        $txt2nd = '2nd On Site';
        $txt3rd = '3rd On Site (Activity Uncomplete)';
        $txt4th = '4th On Site';
        $txt5th = '5th On Site';
    @endphp
@elseif (@$sts_timeline4th->status_activity == 1)
    @php
        $activest = '';
        $activend = '';
        $txt = '1st On Site';
        if ($status_ticket->status == 3) {
            $activerd = 'active';
        } else {
            $activerd = '';
        }
        $active4th = 'active';
        $active5th = '';
        $txt2nd = '2nd On Site';
        $txt3rd = '3rd On Site';
        $txt4th = '4th On Site (Activity Uncomplete)';
        $txt5th = '5th On Site';
    @endphp
@else
    @php
        $activest = '';
        $activend = '';
        $activerd = '';
        $txt = '1st On Site';
        if ($status_ticket->status == 3) {
            $active4th = 'active';
        } else {
            $active4th = '';
        }
        $active5th = 'active';
        $txt2nd = '2nd On Site';
        $txt3rd = '3rd On Site';
        $txt4th = '4th On Site';
        $txt5th = '5th On Site (Activity Uncomplete)';
    @endphp
@endif
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Manage Ticket</a></li>
                <li class="breadcrumb-item active" aria-current="page">Timeline</li>
            </ol>
        </nav>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <h6 class="card-title">
                                    @if ($depart == 6 || $role == 1)
                                        Timeline activity
                                    @else
                                        Activity Engineer at no.Ticket
                                    @endif
                                </h6>
                                <h3>{{ $id }}</h3>
                            </div>
                            @if ($depart == 6 || $role == 1)
                                <div class="col-md-4 text-center">
                                    @php
                                        $validate_act_ticket_onsite = App\Models\ActivityEngineer::select('updated_at')
                                            ->where('notiket', $id)
                                            ->where('act_description', 8)
                                            ->where(function ($query) {
                                                $query->whereNull('updated_at')->orWhere('updated_at', 0);
                                            })
                                            ->orderBy('visitting', 'desc')
                                            ->limit(1)
                                            ->first();
                                    @endphp
                                    @if (!empty($validate_act_ticket_onsite))
                                        @php
                                            $h5 = $status_ticket->status == 2 ? 'Second' : ($status_ticket->status == 3 ? 'Third' : ($status_ticket->status == 4 ? 'Fourth' : 'Fifth'));

                                            $p = $status_ticket->status == 2 ? '2nd' : ($status_ticket->status == 3 ? '3rd' : ($status_ticket->status == 4 ? '4th' : '5th'));
                                        @endphp
                                        <h5 class="text-center"><span
                                                class="badge border border-warning text-dark">{{ $h5 }}
                                                arrival OnSite will be rescheduled</span></h5>
                                        <p class="text-center">*note : acitivity {{ $p }} OnSite must be continue
                                            after the
                                            requested
                                            part is ready by helpdesk</p>
                                    @else
                                        @if (
                                            ($status_ticket->status == 2 && empty($sts_timeline2nd) && $sts_timeline1st->status_activity == 0) ||
                                                ($status_ticket->status == 3 && empty($sts_timeline3rd) && $sts_timeline2nd->status_activity == 0) ||
                                                ($status_ticket->status == 4 && empty($sts_timeline4th) && $sts_timeline3rd->status_activity == 0) ||
                                                ($status_ticket->status == 5 && empty($sts_timeline5th) && $sts_timeline4th->status_activity == 0))
                                            <button type="button"
                                                class="btn btn-inverse-primary btn-icon-text activity-engineer">
                                                Pergi
                                                <i class="btn-icon-append" data-feather="clock"></i>
                                            </button>
                                        @endif
                                    @endif
                                    <form action="{{ url("Update/$id/Engineer-Ticket") }}" id="update-activity"
                                        method="post">
                                        @csrf
                                        {{ method_field('patch') }}
                                        <input type="hidden" name="check_en_part" id="check-part-needornot">
                                        <input type="hidden" name="repair_way" id="repair_way">
                                        <input type="hidden" name="note_reqs_part" id="note-reqs-part">
                                        {{-- <input type="hidden" id="latitude" name="latitude">
                                        <input type="hidden" id="longitude" name="longitude"> --}}
                                    </form>
                                    <input type="hidden" id="status" data-status="{{ $status_ticket->status }}">
                                    @php
                                        if ($status_ticket->status == 1 || ($status_ticket->status == 2 && @$sts_timeline1st->status_activity == 1)) {
                                            $getacdsc = $sts_timeline1st->act_description;
                                        } else {
                                            if (@$sts_timeline2nd->status_activity == 0 && ($status_ticket->status == 3 || ($status_ticket->status == 4 && @$sts_timeline3rd->status_activity == 1))) {
                                                $getacdsc = @$sts_timeline3rd->act_description;
                                            } elseif (@$sts_timeline3rd->status_activity == 0 && ($status_ticket->status == 4 || ($status_ticket->status == 5 && @$sts_timeline4th->status_activity == 1))) {
                                                $getacdsc = @$sts_timeline4th->act_description;
                                            } elseif (@$sts_timeline4th->status_activity == 0 && $status_ticket->status == 5) {
                                                $getacdsc = @$sts_timeline5th->act_description;
                                            } else {
                                                $getacdsc = @$sts_timeline2nd->act_description;
                                            }
                                        }
                                    @endphp
                                    <input id="acdsc" type="hidden" data-acdsc="{{ $getacdsc }}">
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-12 chat-aside border-end-lg">
                                <div class="aside-content">
                                    <div class="aside-body">
                                        <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
                                            @foreach ($tabs as $val)
                                                @php
                                                    if ($val == 1) {
                                                        $cls = $activest;
                                                        $ptxt = $txt;
                                                    } elseif ($val == 2) {
                                                        $cls = $activend;
                                                        $ptxt = $txt2nd;
                                                    } elseif ($val == 3) {
                                                        $cls = $activerd;
                                                        $ptxt = $txt3rd;
                                                    } elseif ($val == 4) {
                                                        $cls = $active4th;
                                                        $ptxt = $txt4th;
                                                    } else {
                                                        $cls = $active5th;
                                                        $ptxt = $txt5th;
                                                    }
                                                @endphp
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $cls }}" id="chats-tab"
                                                        data-bs-toggle="tab" data-bs-target="#timeline-{{ $noTabs }}"
                                                        role="tab" aria-controls="chats" aria-selected="true">
                                                        <div
                                                            class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                            <i data-feather="activity"
                                                                class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                            <p class="d-sm-block">{{ $ptxt }}</p>
                                                        </div>
                                                    </a>
                                                </li>
                                                @php
                                                    $noTabs++;
                                                @endphp
                                                @if (
                                                    $status_ticket->status == $val ||
                                                        ($onsite->total_row != 1 &&
                                                            $onsite->total_row != 2 &&
                                                            $onsite->total_row != 3 &&
                                                            $onsite->total_row != 4 &&
                                                            $onsite->total_row != 5))
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </ul>
                                        <div class="tab-content mt-3">
                                            @php
                                                $val_btn = [1, 2, 3, 4, 5, 6];
                                            @endphp
                                            @foreach ($tabs as $val)
                                                @php
                                                    if ($val == 1) {
                                                        $cls = $activest;
                                                        $ptxt = $txt;
                                                        $var = $act_engineerst;
                                                        $end_site = $end_sitest;
                                                    } elseif ($val == 2) {
                                                        $cls = $activend;
                                                        $ptxt = $txt2nd;
                                                        $var = $act_engineernd;
                                                        $end_site = $end_sitend;
                                                    } elseif ($val == 3) {
                                                        $cls = $activerd;
                                                        $ptxt = $txt3rd;
                                                        $var = $act_engineerrd;
                                                        $end_site = $end_siterd;
                                                    } elseif ($val == 4) {
                                                        $cls = $active4th;
                                                        $ptxt = $txt4th;
                                                        $var = $act_engineer4th;
                                                        $end_site = $end_site4th;
                                                    } else {
                                                        $cls = $active5th;
                                                        $ptxt = $txt5th;
                                                        $var = $act_engineer5th;
                                                        $end_site = $end_site5th;
                                                    }
                                                @endphp
                                                <div class="tab-pane fade show {{ $cls }}"
                                                    id="timeline-{{ $noPane }}" role="tabpanel"
                                                    aria-labelledby="chats-tab">
                                                    <div id="content">
                                                        <ul class="timeline">
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($var as $item)
                                                                <li class="event" data-date="{{ $item->act_time }}">
                                                                    <h3 class="title">{{ $item->sts_ticket }}
                                                                        @if ($depart == 4)
                                                                            {{-- <button type="button"
                                                                                class="btn btn-inverse-success btn-icon btn-xs get-loc-{{ $noPane }}"
                                                                                data-latitudest="{{ $item->latitude }}"
                                                                                data-longitudest="{{ $item->longitude }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#maps{{ $noPane }}">
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="map"></i>
                                                                            </button>
                                                                            <div class="modal fade modal-lg"
                                                                                id="maps{{ $noPane }}" tabindex="-1"
                                                                                aria-labelledby="sourceModalLabel"
                                                                                aria-hidden="true">
                                                                                <div class="modal-dialog">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="sourceModalLabel">
                                                                                                Location
                                                                                            </h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="btn-close"></button>
                                                                                        </div>
                                                                                        <div class="modal-body">
                                                                                            <div
                                                                                                id="map{{ $noPane }}">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> --}}
                                                                        @elseif ($depart == 6 || $role == 1)
                                                                            @foreach ($val_btn as $btn)
                                                                                @php
                                                                                    $txt_btn = $item->act_description == 1 ? 'Pergi' : ($item->act_description == 2 ? 'Arrive' : ($item->act_description == 3 ? 'Work Start' : ($item->act_description == 4 ? 'Work Stop' : ($item->act_description == 5 ? 'Leave Site' : 'Travel Stop'))));
                                                                                @endphp
                                                                                @if (in_array($item->act_description, $val_btn) && $item->status_activity == 1)
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                        {{ $txt_btn }}
                                                                                        <i class="btn-icon-append"
                                                                                            data-feather="clock"></i>
                                                                                    </button>
                                                                                    @php
                                                                                        break;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </h3>
                                                                    <p class="mb-3">{{ $item->keterangan }}</p>
                                                                    {{-- @if ($item->act_description != 1)
                                                                        @if (empty($item->en_attach_id))
                                                                            @if ($depart == 6 || $role == 1)
                                                                                @if (in_array($item->status, $tabs) && !empty($end_site))
                                                                                    <form
                                                                                        action="{{ url('Add-Attachment/Engineer') }}"
                                                                                        method="post"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div
                                                                                            id="file-inputs-{{ $val }}{{ $no }}">
                                                                                            @if ($item->act_description == 5)
                                                                                                <input type="file"
                                                                                                    class="file"
                                                                                                    name="files[]"
                                                                                                    accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"
                                                                                                    id="file-input"
                                                                                                    required />
                                                                                            @else
                                                                                                <input type="file"
                                                                                                    class="file"
                                                                                                    name="files[]"
                                                                                                    accept="image/*"
                                                                                                    capture="camera"
                                                                                                    id="file-input"
                                                                                                    required />
                                                                                            @endif
                                                                                        </div>
                                                                                        <div class="input-group-append"
                                                                                            style="margin-top: 7px;">
                                                                                            <button
                                                                                                id="add-file-button-{{ $val }}{{ $no }}"
                                                                                                class="btn btn-inverse-primary btn-xs"
                                                                                                type="button">
                                                                                                <i class="btn-icon-append icon-md"
                                                                                                    data-feather="plus"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                        <label for="user"
                                                                                            class="form-label">Note
                                                                                            :</label>
                                                                                        <div class="input-group mb-3">
                                                                                            <input type="text"
                                                                                                class="form-control"
                                                                                                name="note_attach"
                                                                                                placeholder="Note"
                                                                                                required>
                                                                                            <input type="hidden"
                                                                                                name="status_attachment"
                                                                                                value="{{ $item->act_description }}">
                                                                                            <input type="hidden"
                                                                                                name="notik"
                                                                                                value="{{ $id }}">
                                                                                            <input type="hidden"
                                                                                                name="onsite"
                                                                                                value="{{ $item->sts_timeline }}">
                                                                                            <div
                                                                                                class="input-group-append">
                                                                                                <button
                                                                                                    class="btn btn-inverse-primary"
                                                                                                    type="submit">
                                                                                                    <i class="btn-icon-append icon-lg"
                                                                                                        data-feather="save"></i>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                @endif
                                                                            @endif
                                                                        @else
                                                                            <a
                                                                                href="{{ url("Ticket=$id/Attachment/$item->en_attach_id") }}">
                                                                                <button
                                                                                    class="btn btn-inverse-primary btn-md"
                                                                                    type="button">
                                                                                    Lihat Attachment
                                                                                    <i class="btn-icon-append icon-md"
                                                                                        data-feather="search"></i>
                                                                                </button>
                                                                            </a>
                                                                        @endif
                                                                    @endif --}}
                                                                </li>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                @php
                                                    $noPane++;
                                                @endphp
                                                @if (
                                                    $status_ticket->status == $val ||
                                                        ($onsite->total_row != 1 &&
                                                            $onsite->total_row != 2 &&
                                                            $onsite->total_row != 3 &&
                                                            $onsite->total_row != 4 &&
                                                            $onsite->total_row != 5))
                                                    @php
                                                        break;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
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
    @if ($depart == 6 || $role == 1)
        <script>
            $('.activity-engineer').on('click', function() {
                let status = document.getElementById('status').dataset.status;
                let act_desc = document.getElementById('acdsc').dataset.acdsc;

                // navigator.geolocation.getCurrentPosition(function(position) {
                //     var lat = position.coords.latitude;
                //     var lng = position.coords.longitude;
                //     document.getElementById('latitude').value = lat;
                //     document.getElementById('longitude').value = lng;
                // }, function(error) {
                //     console.log("Error occurred. Error code: " + error.code);
                // });

                if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && (act_desc == 1 ||
                        act_desc.trim().length == 0))) {
                    var title = "Pergi Sekarang?";
                    var confirmbtn = "Gas";
                } else if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && act_desc ==
                    2)) {
                    var title = "Arrived?";
                    var confirmbtn = "Yes";
                } else if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && act_desc ==
                    3)) {
                    var title = "Start to Work?";
                    var confirmbtn = "Yes";
                } else if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && act_desc ==
                    4)) {
                    if (status == 5) {
                        Swal.fire({
                            title: 'Submit your Repair Way!',
                            text: 'this ticket will be Solve after submit repair way',
                            icon: 'info',
                            input: 'text',
                            inputAttributes: {
                                autocapitalize: 'off',
                                type: 'hidden'
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#34a853',
                            confirmButtonText: 'Save',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Cancel',
                            inputPlaceholder: "input your repair way",
                            inputAttributes: {
                                name: "repair_way"
                            }
                        }).then((result) => {
                            if (result.value) {
                                jQuery('#repair_way').val(result.value);
                                document.getElementById('check-part-needornot').value = 2;
                                jQuery('#update-activity').submit();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Stop to work?',
                            text: 'if will compliting this ticket choose End Case, or u need a part and on site again choose Re-Visit',
                            icon: 'warning',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'End Case',
                            denyButtonText: `Re-Visit`,
                            denyButtonColor: '#fbbc06',
                            cancelButtonColor: '#d33',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: 'Submit your Repair Way!',
                                    text: 'this ticket will be set done after submit repair way',
                                    icon: 'info',
                                    input: 'text',
                                    inputAttributes: {
                                        autocapitalize: 'off',
                                        type: 'hidden',
                                        name: "repair_way"
                                    },
                                    showCancelButton: true,
                                    confirmButtonColor: '#34a853',
                                    confirmButtonText: 'Save',
                                    cancelButtonColor: '#d33',
                                    cancelButtonText: 'Cancel',
                                    inputPlaceholder: "input your repair way",
                                }).then((result) => {
                                    if (result.value) {
                                        jQuery('#repair_way').val(result.value);
                                        document.getElementById('check-part-needornot').value = 2;
                                        jQuery('#update-activity').submit();
                                    }
                                });
                            } else if (result.isDenied) {
                                Swal.fire({
                                    title: 'Need Another Part?',
                                    text: 'If u are request part, the status ticket will be open for the next visit!',
                                    input: 'text',
                                    inputAttributes: {
                                        autocapitalize: 'on',
                                        type: 'hidden',
                                        name: "note_reqs_part"
                                    },
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes',
                                    cancelButtonText: 'No',
                                    inputPlaceholder: "Send your note",
                                }).then((result) => {
                                    if (result.value) {
                                        jQuery('#note-reqs-part').val(result.value);
                                        document.getElementById('check-part-needornot').value = 1;
                                        jQuery('#update-activity').submit();
                                    }
                                });
                            }
                        })
                    }
                } else if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && act_desc ==
                    5)) {
                    var title = "Leave Site?";
                    var confirmbtn = "Yes";
                } else if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && act_desc ==
                    6)) {
                    var title = "Travel Stop?";
                    var confirmbtn = "Yes";
                }
                if (((status == 1 || status == 2 || status == 3 || status == 4 || status == 5) && act_desc != 4)) {
                    Swal.fire({
                        title: title,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#34a853',
                        confirmButtonText: confirmbtn,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery('#update-activity').submit();
                        }
                    });
                    return false;
                }
            });
        </script>
        {{-- <script>
            for (let i = 0; i < 6; i++) {
                for (let j = 0; j < 7; j++) {
                    $('#add-file-button-' + i + j + '').on('click', function() {
                        const fileInputs = document.getElementById('file-inputs-' + i + j + '');
                        const fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.name = 'files[]';
                        fileInput.accept = 'image/*';
                        fileInput.capture = 'camera';
                        fileInputs.appendChild(fileInput);
                    });
                }
            }
        </script> --}}
    @else
        <script>
            // for (let i = 0; i < 50; i++) {
            //     $(document).ready(function() {
            //         $('.get-loc-' + i '').on('click', function() {
            //             var latitudest = $(this).data('latitudest');
            //             var longitudest = $(this).data('longitudest');
            //             if (!isNaN(latitudest) && !isNaN(longitudest)) {
            //                 console.log(latitudest, longitudest);
            //                 initMap(latitudest, longitudest, "map" + i "");
            //             }
            //         });
            //     });
            // }

            // function initMap(latitude, longitude, elementId) {
            //     let myLatLng = {
            //         lat: parseFloat(latitude),
            //         lng: parseFloat(longitude)
            //     };
            //     const map = new google.maps.Map(document.getElementById(elementId), {
            //         zoom: 18,
            //         center: myLatLng,
            //     });

            //     marker = new google.maps.Marker({
            //         map,
            //         animation: google.maps.Animation.DROP,
            //         position: myLatLng,
            //     });
            //     marker.addListener("click", toggleBounce);
            // }

            // function toggleBounce() {
            //     if (marker.getAnimation() !== null) {
            //         marker.setAnimation(null);
            //     } else {
            //         marker.setAnimation(google.maps.Animation.BOUNCE);
            //     }
            // }

            // window.initMap = initMap;
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap">
        </script>
    @endif
@endpush
