@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
@endphp
@if (@$vdt_l2->last_visit == 0)
    @if (@$vdt_l2->status == 0 && @$vdt_l2->last_act < 4)
        @php
            $activest = 'active';
            $activend = '';
            $activerd = '';
            $txt = 'Support 1st (Activity Uncomplete)';
        @endphp
    @else
        @php
            if (@$vdt_l2->sts_ticket == 2) {
                $activend = 'active';
                $activest = '';
            } else {
                $activest = 'active';
                $activend = '';
            }
            $txt = 'Support 1st (Complete)';
            $activerd = '';
        @endphp
    @endif
    @php
        $txt2nd = '2nd Supporting';
    @endphp
@elseif (@$vdt_l2->last_visit == 1)
    @if (@$vdt_l2->status == 0 && @$vdt_l2->last_act < 4)
        @php
            $activest = '';
            $activend = 'active';
            $activerd = '';
            $txt2nd = 'Support 2nd (Activity Uncomplete)';
        @endphp
    @else
        @php
            $activest = '';
            $activend = '';
            $activerd = 'active';
            $txt2nd = 'Support 2nd (Complete)';
        @endphp
    @endif
    @php
        $txt = 'Support 1st (Complete)';
    @endphp
@else
    @php
        $activest = '';
        $activend = '';
        $activerd = 'active';
        $txt = 'Support 1st (Complete)';
        $txt2nd = 'Support 2nd (Complete)';
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
                                    @if ($depart == 13 || $role == 1)
                                        Timeline activity
                                    @else
                                        Activity Engineer at no.Ticket
                                    @endif
                                </h6>
                                <h3>{{ $id }}</h3>
                            </div>
                            @if ($depart == 13 || $role == 1)
                                <div class="col-md-4 text-center">
                                    @php
                                        $validate_act_ticket_onsite = App\Models\ActivityEngineer::select('updated_at')
                                            ->where('notiket', $id)
                                            ->where('act_description', 8)
                                            ->where('visitting', @$vdt_l2->last_visit)
                                            ->orderBy('visitting', 'desc')
                                            ->limit(1)
                                            ->first();
                                    @endphp
                                    @if ((@$vdt_l2->status == 1 && @$vdt_l2->last_visit == 0) || (@$vdt_l2->status == 1 && @$vdt_l2->last_visit == 1))
                                        @if (empty($validate_act_ticket_onsite))
                                            <h5 class="text-center"><span
                                                    class="badge border border-warning text-dark">OnSite will be rescheduled</span></h5>
                                            <p class="text-center">*note : Waiting for helpdesk updating ticket ready to be taken again.</p>
                                        @else
                                            <button type="button"
                                                class="btn btn-inverse-primary btn-icon-text activity-engineerl2">
                                                Stand By
                                                <i class="btn-icon-append" data-feather="clock"></i>
                                            </button>
                                        @endif
                                    @endif
                                    <form action="{{ url("Update/L2-Engineer/$id/Ticket") }}" id="update-activity"
                                        method="post">
                                        @csrf
                                        <input type="hidden" id="latwo-engineer" name="latitude">
                                        <input type="hidden" id="lotwo-engineer" name="longitude">
                                    </form>
                                    <input type="hidden" id="statusl2" data-statusl2="{{ @$vdt_l2->status }}">
                                    <input id="acdscl2" type="hidden"
                                        data-acdscl2="{{ @$vdt_l2->last_act }}">
                                    <input id="vstl2" type="hidden"
                                        data-vstl2="{{ @$vdt_l2->last_visit }}">
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-lg-12 chat-aside border-end-lg">
                                <div class="aside-content">
                                    <div class="aside-body">
                                        <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link {{ $activest }}" id="chats-tab" data-bs-toggle="tab"
                                                    data-bs-target="#timeline-first" role="tab" aria-controls="chats"
                                                    aria-selected="true">
                                                    <div
                                                        class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                        <i data-feather="activity"
                                                            class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                        <p class="d-none d-sm-block">{{ $txt }}</p>
                                                    </div>
                                                </a>
                                            </li>
                                             @if ((@$vdt_l2->status == 1 && @$vdt_l2->last_visit == 0) || (@$vdt_l2->sts_ticket == 2 || @$vdt_l2->sts_ticket == 3))
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $activend }}" id="calls-tab"
                                                        data-bs-toggle="tab" data-bs-target="#timeline-second"
                                                        role="tab" aria-controls="calls" aria-selected="false">
                                                        <div
                                                            class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                            <i data-feather="activity"
                                                                class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                            <p class="d-none d-sm-block">{{ $txt2nd }}</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                             @if ((@$vdt_l2->status == 1 && @$vdt_l2->last_visit == 1) || @$vdt_l2->sts_ticket == 3)
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $activerd }}" id="contacts-tab"
                                                        data-bs-toggle="tab" data-bs-target="#timeline-third" role="tab"
                                                        aria-controls="calls" aria-selected="false">
                                                        <div
                                                            class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                            <i data-feather="activity"
                                                                class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                            <p class="d-none d-sm-block">3rd On Site</p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                        <div class="tab-content mt-3">
                                            <div class="tab-pane fade show {{ $activest }}" id="timeline-first"
                                                role="tabpanel" aria-labelledby="chats-tab">
                                                <div id="content">
                                                    <ul class="timeline">
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($act_engineerst as $item)
                                                            <li class="event" data-date="{{ $item->act_time }}">
                                                                <h3 class="title">{{ $item->sts_ticket }}
                                                                    @if ($depart == 4)
                                                                        <button type="button"
                                                                            class="btn btn-inverse-success btn-icon btn-xs get-loc-st"
                                                                            data-latitudest="{{ $item->latitude }}"
                                                                            data-longitudest="{{ $item->longitude }}"
                                                                            data-bs-toggle="modal" data-bs-target="#maps">
                                                                            <i class="btn-icon-append"
                                                                                data-feather="map"></i>
                                                                        </button>
                                                                        <div class="modal fade modal-lg" id="maps"
                                                                            tabindex="-1"
                                                                            aria-labelledby="sourceModalLabel"
                                                                            aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title"
                                                                                            id="sourceModalLabel">Location
                                                                                        </h5>
                                                                                        <button type="button"
                                                                                            class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="btn-close"></button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div id="mapst"></div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                            class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif ($depart == 13 || $role == 1)
                                                                        @php
                                                                        if ($item->act_description == 1) {
                                                                            $desc = "Work Start";
                                                                        } elseif ($item->act_description == 2) {
                                                                            $desc = "Work Stop";
                                                                        } elseif ($item->act_description == 3) {
                                                                            $desc = "End Case";
                                                                        }
                                                                        @endphp
                                                                        @if ($item->act_description == @$vdt_l2->last_act && $item->sts_timeline == @$vdt_l2->last_visit)
                                                                            @if ($item->act_description < 4)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineerl2">
                                                                                    {{$desc}}
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @endif
                                                                        @endif
                                                                    @endif
                                                                </h3>
                                                                @if (empty($item->en_attach_id))
                                                                    <form
                                                                        action="{{ url('Add/Timeline-Note/L2-Engineer') }}"
                                                                        method="post"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <label for="user"
                                                                            class="form-label">Note
                                                                            :</label>
                                                                        <div class="input-group mb-3">
                                                                            <input type="text"
                                                                                class="form-control"
                                                                                name="note_attach"
                                                                                placeholder="Note" required>
                                                                            <input type="hidden"
                                                                                name="status_attachment"
                                                                                value="{{ $item->act_description }}">
                                                                            <input type="hidden"
                                                                                name="notik"
                                                                                value="{{ $id }}">
                                                                            <input type="hidden"
                                                                                name="onsite" value="0">
                                                                            <div class="input-group-append">
                                                                                <button
                                                                                    class="btn btn-inverse-primary"
                                                                                    type="submit">
                                                                                    <i class="btn-icon-append icon-lg"
                                                                                        data-feather="save"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                @else
                                                                    <label for="user"
                                                                        class="form-label">Note
                                                                        : {{ $item->note }}</label>
                                                                @endif
                                                            </li>
                                                            @php
                                                                $no++;
                                                            @endphp
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            @if (@$vdt_l2->status == 1 || (@$vdt_l2->last_visit == 1 || @$vdt_l2->last_visit == 2))
                                                <div class="tab-pane fade show {{ $activend }}" id="timeline-second"
                                                    role="tabpanel" aria-labelledby="calls-tab">
                                                    <div id="content">
                                                        <ul class="timeline">
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($act_engineernd as $item)
                                                                <li class="event" data-date="{{ $item->act_time }}">
                                                                    <h3 class="title">{{ $item->sts_ticket }}
                                                                        @if ($depart == 4)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-success btn-icon btn-xs get-loc-nd"
                                                                                data-latitudend="{{ $item->latitude }}"
                                                                                data-longitudend="{{ $item->longitude }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#map2nd">
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="map"></i>
                                                                            </button>
                                                                            <div class="modal fade modal-lg"
                                                                                id="map2nd" tabindex="-1"
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
                                                                                            <div id="mapnd"></div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @elseif ($depart == 13 || $role == 1)
                                                                            @php
                                                                            if ($item->act_description == 1) {
                                                                                $desc = "Work Start";
                                                                            } elseif ($item->act_description == 2) {
                                                                                $desc = "Work Stop";
                                                                            } elseif ($item->act_description == 3) {
                                                                                $desc = "End Case";
                                                                            }
                                                                            @endphp
                                                                            @if ($item->act_description == @$vdt_l2->last_act && $item->sts_timeline == @$vdt_l2->last_visit)
                                                                                @if ($item->act_description < 4)
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineerl2">
                                                                                        {{$desc}}
                                                                                        <i class="btn-icon-append"
                                                                                            data-feather="clock"></i>
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    </h3>
                                                                    <p class="mb-3">{{ $item->keterangan }}</p>
                                                                    @if (empty($item->en_attach_id))
                                                                        <form
                                                                            action="{{ url('Add/Timeline-Note/L2-Engineer') }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
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
                                                                                    value="1">
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
                                                                    @else
                                                                        <label for="user"
                                                                            class="form-label">Note
                                                                            : {{ $item->note }}</label>
                                                                    @endif
                                                                </li>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (@$vdt_l2->status == 1 || @$vdt_l2->last_visit == 2)
                                                <div class="tab-pane fade show {{ $activerd }}" id="timeline-third"
                                                    role="tabpanel" aria-labelledby="contacts-tab">
                                                    <div id="content">
                                                        <ul class="timeline">
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($act_engineerrd as $item)
                                                                <li class="event" data-date="{{ $item->act_time }}">
                                                                    <h3 class="title">{{ $item->sts_ticket }}
                                                                        @if ($depart == 4)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-success btn-icon btn-xs get-loc-rd"
                                                                                data-latituderd="{{ $item->latitude }}"
                                                                                data-longituderd="{{ $item->longitude }}"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#map2rd">
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="map"></i>
                                                                            </button>
                                                                            <div class="modal fade modal-lg"
                                                                                id="map2rd" tabindex="-1"
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
                                                                                            <div id="maprd"></div>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button"
                                                                                                class="btn btn-secondary"
                                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @elseif ($depart == 13 || $role == 1)
                                                                            @php
                                                                            if ($item->act_description == 1) {
                                                                                $desc = "Work Start";
                                                                            } elseif ($item->act_description == 2) {
                                                                                $desc = "Work Stop";
                                                                            } elseif ($item->act_description == 3) {
                                                                                $desc = "End Case";
                                                                            }
                                                                            @endphp
                                                                            @if ($item->act_description == @$vdt_l2->last_act)
                                                                                @if ($item->act_description < 4)
                                                                                    <button type="button"
                                                                                        class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineerl2">
                                                                                        {{$desc}}
                                                                                        <i class="btn-icon-append"
                                                                                            data-feather="clock"></i>
                                                                                    </button>
                                                                                @endif
                                                                            @endif
                                                                        @endif
                                                                    </h3>
                                                                    <p class="mb-3">{{ $item->keterangan }}</p>
                                                                    @if (empty($item->en_attach_id))
                                                                        <form
                                                                            action="{{ url('Add-Attachment/Engineer') }}"
                                                                            method="post"
                                                                            enctype="multipart/form-data">
                                                                            @csrf
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
                                                                                    value="2">
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
                                                                    @else
                                                                        <label for="user"
                                                                            class="form-label">Note
                                                                            : {{ $item->note }}</label>
                                                                    @endif
                                                                </li>
                                                                @php
                                                                    $no++;
                                                                @endphp
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
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
    @if ($depart == 13 || $role == 1)
        <script>
            $('.activity-engineerl2').on('click', function() {vstl2
                let status = document.getElementById('statusl2').dataset.statusl2;
                let act_desc = document.getElementById('acdscl2').dataset.acdscl2;
                let visit = document.getElementById('vstl2').dataset.vstl2;

                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    document.getElementById('latwo-engineer').value = lat;
                    document.getElementById('lotwo-engineer').value = lng;
                }, function(error) {
                    console.log("Error occurred. Error code: " + error.code);
                });
                if (act_desc == 1) {
                    var title = "Start to Work?";
                    var confirmbtn = "Yes";
                } else if (act_desc == 2) {
                    var title = "Stop to Work?";
                    var confirmbtn = "Yes";
                } else if (act_desc == 3) {
                    var title = "End this Case?";
                    var confirmbtn = "Yes";
                } else if (act_desc == 4 && status == 1 && (visit == 0 || visit == 1)) {
                    if (visit == 0) {
                        var title = "2nd: Stand By?";
                    }else{
                        var title = "3rd: Stand By?";
                    }
                    var confirmbtn = "Yes";
                }
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
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('.get-loc-st').on('click', function() {
                    var latitudest = $(this).data('latitudest');
                    var longitudest = $(this).data('longitudest');
                    if (!isNaN(latitudest) && !isNaN(longitudest)) {
                        console.log(latitudest, longitudest);
                        initMap(latitudest, longitudest, "mapst");
                    }
                });

                $('.get-loc-nd').on('click', function() {
                    var latitudend = $(this).data('latitudend');
                    var longitudend = $(this).data('longitudend');
                    if (!isNaN(latitudend) && !isNaN(longitudend)) {
                        console.log(latitudend, longitudend);
                        initMap(latitudend, longitudend, "mapnd");
                    }
                });

                $('.get-loc-rd').on('click', function() {
                    var latituderd = $(this).data('latituderd');
                    var longituderd = $(this).data('longituderd');
                    if (!isNaN(latituderd) && !isNaN(longituderd)) {
                        console.log(latituderd, longituderd);
                        initMap(latituderd, longituderd, "maprd");
                    }
                });
            });

            function initMap(latitude, longitude, elementId) {
                let myLatLng = {
                    lat: parseFloat(latitude),
                    lng: parseFloat(longitude)
                };
                const map = new google.maps.Map(document.getElementById(elementId), {
                    zoom: 18,
                    center: myLatLng,
                });

                marker = new google.maps.Marker({
                    map,
                    animation: google.maps.Animation.DROP,
                    position: myLatLng,
                });
                marker.addListener("click", toggleBounce);
            }

            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }

            window.initMap = initMap;
        </script>

        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap">
        </script>
    @endif
@endpush