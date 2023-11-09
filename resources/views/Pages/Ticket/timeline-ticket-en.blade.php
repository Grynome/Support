@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
@endphp
@if ($sts_timeline1st->status_activity == 1)
    @php
        $activest = 'active';
        $activend = '';
        $txt = '1st On Site (Activity Uncomplete)';
        $txt2nd = '2nd On Site';
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
        $txt = '1st On Site';
        $txt2nd = '2nd On Site (Activity Uncomplete)';
    @endphp
@else
    @php
        $activest = '';
        $txt = '1st On Site';
        if ($status_ticket->status == 2) {
            $activend = 'active';
        } else {
            $activend = '';
        }
        $activerd = 'active';
        $txt2nd = '2nd On Site';
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
                                        @if ($status_ticket->status == 2)
                                            <h5 class="text-center"><span
                                                    class="badge border border-warning text-dark">second
                                                    arrival OnSite will be rescheduled</span></h5>
                                            <p class="text-center">*note : acitivity 2nd OnSite must be continue after the
                                                requested
                                                part is ready by helpdesk</p>
                                        @else
                                            <h5 class="text-center"><span
                                                    class="badge border border-warning text-dark">Third
                                                    arrival OnSite will be rescheduled</span></h5>
                                            <p class="text-center">*note : acitivity 3rd OnSite must be continue after the
                                                requested
                                                part is ready by helpdesk</p>
                                        @endif
                                    @else
                                        @if ($status_ticket->status == 2 && empty($sts_timeline2nd) && $sts_timeline1st->status_activity == 0)
                                            <button type="button"
                                                class="btn btn-inverse-primary btn-icon-text activity-engineer">
                                                Pergi
                                                <i class="btn-icon-append" data-feather="clock"></i>
                                            </button>
                                        @endif
                                        @if ($status_ticket->status == 3 && empty($sts_timeline3rd) && $sts_timeline2nd->status_activity == 0)
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
                                        <input type="hidden" id="latitude" name="latitude">
                                        <input type="hidden" id="longitude" name="longitude">
                                    </form>
                                    <input type="hidden" id="status" data-status="{{ $status_ticket->status }}">
                                    @if ($status_ticket->status == 2 || $status_ticket->status == 3)
                                        @if (@$sts_timeline2nd->status_activity == 0)
                                            <input id="acdsc" type="hidden"
                                                data-acdsc="{{ @$sts_timeline3rd->act_description }}">
                                        @else
                                            <input id="acdsc" type="hidden"
                                                data-acdsc="{{ @$sts_timeline2nd->act_description }}">
                                        @endif
                                    @else
                                        <input id="acdsc" type="hidden"
                                            data-acdsc="{{ $sts_timeline1st->act_description }}">
                                    @endif
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
                                            @if ($status_ticket->status == 2 || $onsite->total_row != 1)
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
                                            @if ($status_ticket->status == 3 || ($onsite->total_row != 1 && $onsite->total_row != 2))
                                                <li class="nav-item">
                                                    <a class="nav-link {{ $activerd }}" id="calls-tab"
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
                                                                    @elseif ($depart == 6 || $role == 1)
                                                                        @if ($item->act_description == 1 && $item->status_activity == 1)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                Pergi
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="clock"></i>
                                                                            </button>
                                                                        @elseif ($item->act_description == 2 && $item->status_activity == 1)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                Arrive
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="clock"></i>
                                                                            </button>
                                                                        @elseif ($item->act_description == 3 && $item->status_activity == 1)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                Work Start
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="clock"></i>
                                                                            </button>
                                                                        @elseif ($item->act_description == 4 && $item->status_activity == 1)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                Work Stop
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="clock"></i>
                                                                            </button>
                                                                        @elseif ($item->act_description == 5 && $item->status_activity == 1)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                Leave Site
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="clock"></i>
                                                                            </button>
                                                                        @elseif ($item->act_description == 6 && $item->status_activity == 1)
                                                                            <button type="button"
                                                                                class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                Travel Stop
                                                                                <i class="btn-icon-append"
                                                                                    data-feather="clock"></i>
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                </h3>
                                                                <p class="mb-3">{{ $item->keterangan }}</p>
                                                                @if ($item->act_description != 1)
                                                                    @if (empty($item->en_attach_id))
                                                                        @if ($depart == 6 || $role == 1)
                                                                            @if (($item->status == 1 || $item->status == 2) && !empty($end_sitest))
                                                                                <form
                                                                                    action="{{ url('Add-Attachment/Engineer') }}"
                                                                                    method="post"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div
                                                                                        id="file-inputs-st{{ $no }}">
                                                                                        @if ($item->act_description == 5)
                                                                                            <input type="file"
                                                                                                class="file"
                                                                                                name="files[]"
                                                                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"
                                                                                                id="file-input" required />
                                                                                        @else
                                                                                            <input type="file"
                                                                                                class="file"
                                                                                                name="files[]"
                                                                                                accept="image/*"
                                                                                                capture="camera"
                                                                                                id="file-input" required />
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="input-group-append"
                                                                                        style="margin-top: 7px;">
                                                                                        <button
                                                                                            id="add-file-button-st{{ $no }}"
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
                                                                            @endif
                                                                        @endif
                                                                    @else
                                                                        <a
                                                                            href="{{ url("Ticket=$id/Attachment/$item->en_attach_id") }}">
                                                                            <button class="btn btn-inverse-primary btn-md"
                                                                                type="button">
                                                                                Lihat Attachment
                                                                                <i class="btn-icon-append icon-md"
                                                                                    data-feather="search"></i>
                                                                            </button>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            </li>
                                                            @php
                                                                $no++;
                                                            @endphp
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            @if ($status_ticket->status == 2 || $onsite->total_row != 1)
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
                                                                        @elseif ($depart == 6 || $role == 1)
                                                                            @if ($item->act_description == 1 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Pergi
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 2 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Arrive
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 3 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Work Start
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 4 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Work Stop
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 5 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Leave Site
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 6 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Travel Stop
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @endif
                                                                        @endif
                                                                    </h3>
                                                                    <p class="mb-3">{{ $item->keterangan }}</p>
                                                                    @if ($item->act_description != 1)
                                                                        @if (empty($item->en_attach_id))
                                                                            @if ($depart == 6 || $role == 1)
                                                                                @if (($item->status == 2 || $item->status == 3) && !empty($end_sitend))
                                                                                    <form
                                                                                        action="{{ url('Add-Attachment/Engineer') }}"
                                                                                        method="post"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div
                                                                                            id="file-inputs-nd{{ $no }}">
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
                                                                                                id="add-file-button-nd{{ $no }}"
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
                                            @if ($status_ticket->status == 3 || $onsite->total_row != 1)
                                                <div class="tab-pane fade show {{ $activerd }}" id="timeline-third"
                                                    role="tabpanel" aria-labelledby="calls-tab">
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
                                                                        @elseif ($depart == 6 || $role == 1)
                                                                            @if ($item->act_description == 1 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Pergi
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 2 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Arrive
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 3 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Work Start
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 4 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Work Stop
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 5 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Leave Site
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @elseif ($item->act_description == 6 && $item->status_activity == 1)
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-primary btn-icon-text btn-xs activity-engineer">
                                                                                    Travel Stop
                                                                                    <i class="btn-icon-append"
                                                                                        data-feather="clock"></i>
                                                                                </button>
                                                                            @endif
                                                                        @endif
                                                                    </h3>
                                                                    <p class="mb-3">{{ $item->keterangan }}</p>
                                                                    @if ($item->act_description != 1)
                                                                        @if (empty($item->en_attach_id))
                                                                            @if ($depart == 6 || $role == 1)
                                                                                @if (($item->status == 2 || $item->status == 3) && !empty($end_siterd))
                                                                                    <form
                                                                                        action="{{ url('Add-Attachment/Engineer') }}"
                                                                                        method="post"
                                                                                        enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div
                                                                                            id="file-inputs-rd{{ $no }}">
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
                                                                                                id="add-file-button-rd{{ $no }}"
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
    @if ($depart == 6 || $role == 1)
        <script>
            $('.activity-engineer').on('click', function() {
                let status = document.getElementById('status').dataset.status;
                let act_desc = document.getElementById('acdsc').dataset.acdsc;

                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                }, function(error) {
                    console.log("Error occurred. Error code: " + error.code);
                });
                if (((status == 1 || status == 2 || status == 3) && (act_desc == 1 || act_desc.trim().length == 0))) {
                    var title = "Pergi Sekarang?";
                    var confirmbtn = "Gas";
                } else if (((status == 1 || status == 2 || status == 3) && act_desc == 2)) {
                    var title = "Arrived?";
                    var confirmbtn = "Yes";
                } else if (((status == 1 || status == 2 || status == 3) && act_desc == 3)) {
                    var title = "Start to Work?";
                    var confirmbtn = "Yes";
                } else if (((status == 1 || status == 2 || status == 3) && act_desc == 4)) {
                    if (status == 3) {
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
                            text: 'if will compliting this ticket choose done, or u need a part and on site again choose Need Part',
                            icon: 'question',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Done',
                            denyButtonText: `Need Part`,
                            cancelButtonColor: '#d33',
                            // denyButtonColor: '#3085d6',
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
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
                } else if (((status == 1 || status == 2 || status == 3) && act_desc == 5)) {
                    var title = "Leave Site?";
                    var confirmbtn = "Yes";
                } else if (((status == 1 || status == 2 || status == 3) && act_desc == 6)) {
                    var title = "Travel Stop?";
                    var confirmbtn = "Yes";
                }
                if (((status == 1 || status == 2 || status == 3) && act_desc != 4)) {
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
        <script>
            for (let i = 0; i < 50; i++) {
                $('#add-file-button-st' + i + '').on('click', function() {
                    const fileInputs = document.getElementById('file-inputs-st' + i + '');
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'files[]';
                    fileInput.accept = 'image/*';
                    fileInput.capture = 'camera';
                    fileInputs.appendChild(fileInput);
                });
                $('#add-file-button-nd' + i + '').on('click', function() {
                    const fileInputs = document.getElementById('file-inputs-nd' + i + '');
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'files[]';
                    fileInput.accept = 'image/*';
                    fileInput.capture = 'camera';
                    fileInputs.appendChild(fileInput);
                });
                $('#add-file-button-rd' + i + '').on('click', function() {
                    const fileInputs = document.getElementById('file-inputs-rd' + i + '');
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'files[]';
                    fileInput.accept = 'image/*';
                    fileInput.capture = 'camera';
                    fileInputs.appendChild(fileInput);
                });
            }
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
