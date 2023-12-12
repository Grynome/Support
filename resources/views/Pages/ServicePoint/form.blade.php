@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Form / Service Point</a></li>
                @if (empty($data_sp))
                    <li class="breadcrumb-item active" aria-current="page">Add New Data Service Point</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">Edit Data Service Point</li>
                @endif
            </ol>
        </nav>
        <form class="forms-sample"
            action="{{ empty($data_sp) ? url('Add/data=ServicePoint') : url("Edit/$data_sp->service_id/data=ServicePoint") }}"
            method="post" id="sp-info-form">
            @csrf
            @if (!empty($data_sp))
                {{ method_field('patch') }}
            @endif
            <div class="row">
                <div class="col-md-9 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Service Point Info</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <div class="col-md-7">
                                            <label for="ServicePoint" class="form-label">Service Point Name</label>
                                            <input id="sp-val" class="form-control" name="sp_name" type="text"
                                                value="{{ @$data_sp->service_name }}">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="Province" class="form-label">Ownership</label>
                                            <select class="js-example-basic-single form-select" data-width="100%"
                                                name="ownership_sp" id="ownership-sp">
                                                <option value="">- Select Owner -</option>
                                                <option value="1" {{ @$data_sp->ownership == 1 ? 'selected' : '' }}>HGT</option>
                                                <option value="2" {{ @$data_sp->ownership == 2 ? 'selected' : '' }}>Partner</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="Province" class="form-label">Provinsi</label>
                                            <select class="js-example-basic-single form-select" data-width="100%"
                                                name="provinces_sp" id="provinces-sp">
                                                <option value="">- Select Option -</option>
                                                @foreach ($province as $item)
                                                    <option value="{{ $item->id ?? '' }}"
                                                        {{ @$data_sp->provinsi_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Email" class="form-label">Kabupaten</label>
                                            <select class="js-example-basic-single form-select" data-width="100%"
                                                name="cities_sp" id="cities-sp">
                                                <option>- Select Option -</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="Phone" class="form-label">Phone</label>
                                            <input class="form-control mb-4 mb-md-0"
                                                data-inputmask-alias="(+62) 999-9999-9999" name="phone" id="phone-sp"
                                                value="{{ @$data_sp->phone }}" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Email" class="form-label">Email</label>
                                            <input class="form-control mb-4 mb-md-0" name="email" id="mail-sp"
                                                data-inputmask="'alias': 'email'" value="{{ @$data_sp->email }}" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">Address</label>
                                            <textarea class="form-control" name="address" id="alamat-sp" maxlength="150" rows="3" placeholder="Type Address">{{ @$data_sp->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Head of Services Point</h6>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="reference" class="form-label">Head</label>
                                    <input type="text" id="head-of-sp" name="nik_head" style="display: none;"
                                        value="{{ @$data_sp->head }}">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Head's name"
                                            aria-label="Recipient's name" aria-describedby="basic-addon2" id="name-head"
                                            name="name_head" value="{{ @$data_sp->head }}" disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-inverse-primary" type="button" data-bs-toggle="modal"
                                                data-bs-target="#find-head"><i class="btn-icon-append icon-lg"
                                                    data-feather="search"></i></button>
                                        </div>
                                        <div class="modal fade bd-example-modal-lg" id="find-head" tabindex="-1"
                                            aria-labelledby="projectModal" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="projectModal">Select Option Head
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="btn-close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table id="display" class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>NIK</th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Role</th>
                                                                        <th>Department</th>
                                                                        <th>Option</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $no = 1;
                                                                    @endphp
                                                                    @foreach ($user as $item)
                                                                        <tr>
                                                                            <td>{{ $no }}</td>
                                                                            <td>{{ $item->nik }}</td>
                                                                            <td>{{ $item->full_name }}</td>
                                                                            <td>{{ $item->email }}</td>
                                                                            <td>{{ @$item->roles->role }}</td>
                                                                            <td>{{ @$item->dept->department }}</td>
                                                                            <td>
                                                                                <button type="button"
                                                                                    class="btn btn-inverse-info btn-icon btn-sm select-head">
                                                                                    <i data-feather="mouse-pointer"></i>
                                                                                </button>
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
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <button type="button" class="btn btn-inverse-success saved-sp"> Save </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
    <script>
        $('.saved-sp').on('click', function() {

            function getCTSPVal() {
                var ct_sp_val = document.getElementById("cities-sp").value;
                return ct_sp_val;
            };

            if ($('#sp-val').val() === "" || $('#ownership-sp').val() === "" || $('#provinces-sp').val() === "" || getCTSPVal() === "" || $(
                    '#phone-sp').val() === "" || $('#mail-sp').val() === "" || $('#alamat-sp').val() === "" || $(
                    '#head-of-sp').val() === "") {
                if ($('#sp-val').val() === "" && $('#ownership-sp').val() === "" && $('#provinces-sp').val() === "" && getCTSPVal() === "" && $(
                        '#phone-sp').val() === "" && $('#mail-sp').val() === "" && $('#alamat-sp').val() === "" &&
                    $('#head-of-sp').val() === "") {
                    Swal.fire({
                        title: "All Field's cannot be empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#sp-val').val() === "") {
                    Swal.fire({
                        title: "Service name its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#ownership-sp').val() === "") {
                    Swal.fire({
                        title: "Ownership its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#provinces-sp').val() === "") {
                    Swal.fire({
                        title: "Provinsi its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if (getCTSPVal() === "") {
                    Swal.fire({
                        title: "Kabupaten its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#phone-sp').val() === "") {
                    Swal.fire({
                        title: "Phone its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#mail-sp').val() === "") {
                    Swal.fire({
                        title: "Mail its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#alamat-sp').val() === "") {
                    Swal.fire({
                        title: "Address its empty!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                } else if ($('#head-of-sp').val() === "") {
                    Swal.fire({
                        title: "Must add head of sp!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                    });
                }
            } else {
                Swal.fire({
                    title: "Save this data?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery("#sp-info-form").submit();
                    }
                })
            }
            return false;
        });
    </script>
    <script>
        function onChangeSelectSP(url, id, name) {
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#' + name).empty();
                    $('#' + name).append('<option value="">- Select Option -</option>');

                    $.each(data, function(key, value) {
                        $('#' + name).append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        }
        $(function() {
            $('#provinces-sp').on('change', function() {
                onChangeSelectSP('{{ route('cities') }}', $(this).val(), 'cities-sp');
            });
        });
    </script>
@endpush
