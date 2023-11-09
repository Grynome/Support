@push('css-plugin')
@endpush
@extends('Theme/header')
@php
    $depart = auth()->user()->depart;
    $role = auth()->user()->role;
    use Carbon\Carbon;
@endphp
@section('getPage')
    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Activity PIC</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Acitivity PIC</h6>
                            </div>
                            @if ($depart == 3 || $role == 20)
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-inverse-primary btn-icon-text"
                                        data-bs-toggle="modal" data-bs-target="#src_hgt">
                                        <i class="btn-icon-prepend" data-feather="plus"></i>
                                        Activity
                                    </button>
                                    <div class="modal fade" id="src_hgt" tabindex="-1" aria-labelledby="sourceModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="sourceModalLabel">Adding Activity
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="btn-close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ url('Add/Act-Desc/PIC') }}" method="post"
                                                        id="store-pic-act">
                                                        @csrf
                                                        <div class="row border-bottom-dt mb-3">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="date_come" class="form-label">Date/Time
                                                                    :</label>
                                                                <input type="text" class="form-control date-time-tap"
                                                                    placeholder="Select Date/Time" name="val_dt_tap"
                                                                    id="flatpickr-date-time" data-input>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="Type Activity" class="form-label">Type Activity
                                                                    :</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="select_val_tap"
                                                                    id="select-val-tap">
                                                                    <option value="">- Choose -</option>
                                                                    @foreach ($type_act as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="Detil Desc" class="form-label">Detil Description
                                                                    :</label>
                                                                <textarea id="act-pic-desc" class="form-control" name="desc_pic" rows="3" placeholder="Type Description"></textarea>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button"
                                                        class="btn btn-success store-pic-act">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table id="display" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Type Activity</th>
                                        <th>Description</th>
                                        <th>Activity At</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($activity as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ @$item->pic->full_name }}</td>
                                            <td>{{ @$item->type->name }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ Carbon::parse($item->tanggal)->format('Y-m-d H:i') }}</td>
                                            <td>
                                                @if ($depart == 3 || $role == 20)
                                                    <div class="btn-toolbar" role="toolbar"
                                                        aria-label="Toolbar with button groups">
                                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                                            <button type="button"
                                                                class="btn btn-inverse-info btn-icon btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit_src{{ $no }}">
                                                                <i data-feather="edit"></i>
                                                            </button>
                                                            <div class="modal fade" id="edit_src{{ $no }}"
                                                                tabindex="-1" aria-labelledby="sourceModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="sourceModalLabel">
                                                                                Edit Description
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="btn-close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form
                                                                                action="{{ url("Edit/Act-Desc/$item->id/PIC") }}"
                                                                                method="post"
                                                                                id="fm-dt-desc{{ $no }}">
                                                                                @csrf
                                                                                {{ method_field('patch') }}
                                                                                <div class="row border-bottom-dt mb-3">
                                                                                    <div class="col-md-12 mb-3">
                                                                                        <label for="date_come"
                                                                                            class="form-label">Date/Time
                                                                                            :</label>
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            placeholder="Select Date"
                                                                                            name="edt_dt_tap"
                                                                                            id="flatpickr-date-time"
                                                                                            value="{{ Carbon::parse($item->tanggal)->format('Y-m-d H:i') }}"
                                                                                            data-input>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-3">
                                                                                        <div class="mb-3">
                                                                                            <label for="condition"
                                                                                                class="form-label">Type
                                                                                                Activity</label>
                                                                                            <select
                                                                                                class="js-example-basic-single form-select"
                                                                                                data-width="100%"
                                                                                                name="edt_type_act_pic"
                                                                                                required>
                                                                                                <option value="">-
                                                                                                    Choose -</option>
                                                                                                @foreach ($type_act as $type)
                                                                                                    <option
                                                                                                        value="{{ $type->id }}"
                                                                                                        {{ @$item->type->id == $type->id ? 'selected' : '' }}>
                                                                                                        {{ $type->name }}
                                                                                                    </option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="mb-3">
                                                                                            <label for="detail"
                                                                                                class="form-label">Description</label>
                                                                                            <textarea class="form-control" name="edt_desc_pic" id="defaultconfig-4" rows="3" placeholder="Type Detail">{{ $item->description }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="button"
                                                                                class="btn btn-success fm-dt-desc{{ $no }}">Edit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            &nbsp;
                                                            <button type="button"
                                                                class="btn btn-inverse-warning btn-icon btn-sm remove-act-desc{{ $no }}">
                                                                <i data-feather="delete"></i>
                                                            </button>
                                                            <form action="{{ url("Delete/Act-Desc/$item->id/PIC") }}"
                                                                method="post" id="remove-act-desc{{ $no }}">
                                                                @csrf
                                                                {{ method_field('delete') }}
                                                            </form>
                                                        </div>
                                                    </div>
                                                @else
                                                    No Option
                                                @endif
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
