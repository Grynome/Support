@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    <div class="page-content">
    @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">SLA</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Service License Agreement</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#add_sla">
                                    ADD SLA
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>
                                <div class="modal fade" id="add_sla" tabindex="-1" aria-labelledby="slaModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="slaModalLabel">Adding SLA
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/SLA-HGT') }}" method="post" id="form_add_sla">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="sla_name" class="form-label">SLA
                                                                    Name</label>
                                                                <input type="text" class="form-control" id="sla_name"
                                                                    name="sla_name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="longer" class="form-label">Longer</label>
                                                                <div class="row">
                                                                    <div class="col-md 10">
                                                                        <input type="number" class="form-control"
                                                                            name="longer" id="longer" required>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <input type="text" class="form-control"
                                                                            value="Jam" disabled>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="condition" class="form-label">Condition</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" id="condition" name="condition"
                                                                    required>
                                                                    <option value="">- Choose -</option>
                                                                    <option value="2">Work HOURS</option>
                                                                    <option value="1">Normal</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button" class="btn btn-success add_sla">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>SLA Name</th>
                                        <th>Time</th>
                                        <th>Condition</th>
                                        <th>Created at</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($sla as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->sla_name }}</td>
                                            <td>{{ $item->lama . ' Jam' }}</td>
                                            @if ($item->kondisi == 1)
                                                <td>Normal</td>
                                            @else
                                                <td>Work Hours</td>
                                            @endif
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-inverse-info btn-icon btn-sm"
                                                    data-bs-toggle="modal" data-bs-target="#edit_sla{{ $no }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <div class="modal fade" id="edit_sla{{ $no }}" tabindex="-1"
                                                    aria-labelledby="slaModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="slaModalLabel">Edit SLA
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="btn-close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @php
                                                                    $sla_id = $item->sla_id;
                                                                @endphp
                                                                <form action="{{ url("Update/$sla_id/SLA-HGT") }}"
                                                                    method="post" id="form_edit_sla{{ $no }}">
                                                                    @csrf
                                                                    {{ method_field('patch') }}
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="edit_name"
                                                                                    class="form-label">SLA
                                                                                    Name</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="edit_name"
                                                                                    value="{{ $item->sla_name }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="edit_lama"
                                                                                    class="form-label">Longer</label>
                                                                                <div class="row">
                                                                                    <div class="col-md-10">
                                                                                        <input type="number"
                                                                                            class="form-control"
                                                                                            name="edit_lama"
                                                                                            value="{{ $item->lama }}">
                                                                                    </div>
                                                                                    <div class="col-md-2">
                                                                                        <input type="text"
                                                                                            class="form-control"
                                                                                            value="Jam" disabled>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label for="edit_condition"
                                                                                    class="form-label">Condition</label><br>
                                                                                <select
                                                                                    class="js-example-basic-single form-control form-select"
                                                                                    data-width="100%" name="edt_condition">
                                                                                    <option value="1"
                                                                                        {{ $item->kondisi == '1' ? 'selected' : '' }}>
                                                                                        Normal</option>
                                                                                    <option value="2"
                                                                                        {{ $item->kondisi == '2' ? 'selected' : '' }}>
                                                                                        Work HOURS</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-success edit-sla{{ $no }}">Edit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                |
                                                <button type="button"
                                                    class="btn btn-inverse-warning btn-icon btn-sm remove-sla{{ $no }}">
                                                    <i data-feather="delete"></i>
                                                </button>
                                                <form action="{{ url("Remove/$sla_id/SLA-HGT") }}" method="post"
                                                    id="remove_sla{{ $no }}">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                </form>
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
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
<script>
</script>
@endpush
