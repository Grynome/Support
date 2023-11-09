@php
    $role = auth()->user()->role;
    $depart = auth()->user()->depart;
@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Ticket</li>
                <li class="breadcrumb-item active" aria-current="page">Activity</li>
                <li class="breadcrumb-item active" aria-current="page">Attachment</li>
            </ol>
        </nav>
        {{-- <div class="row mb-3">
            <div class="col-md-12">
                <div class="card rounded">
                    <div class="card-body"></div>
                </div>
            </div>
        </div> --}}
        <div class="row profile-body">
            <!-- left wrapper start -->
            <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
                <div class="card rounded">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="card-title mb-0">Note</h6>
                            <div class="dropdown">
                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if ($depart == 6)
                                        <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal"
                                            href="#add-attach"><i data-feather="plus" class="icon-sm me-2"></i> <span
                                                class="">Add</span></a>
                                    @endif
                                    <a href="javascript:;" class="dropdown-item d-flex align-items-center">
                                        <i data-feather="eye" class="icon-sm me-2"></i>
                                        <span class="">View all</span>
                                    </a>
                                </div>
                            </div>
                            @if ($depart == 6)
                                <div class="modal fade" id="add-attach" tabindex="-1" aria-labelledby="sourceModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Upload Files
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url("Add/Attachment/$info->en_attach_id") }}" method="post" id="form-store-another-attach"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div id="file-inputs-dt">
                                                        <input type="file" class="file" name="files_detil[]" accept="image/*" id="file-upload"
                                                            capture="camera"/>
                                                    </div>
                                                    <div class="input-group-append" style="margin-top: 7px;">
                                                        <button id="add-another-file-dt" class="btn btn-inverse-primary btn-xs"
                                                            type="button">
                                                            <i class="btn-icon-append icon-md" data-feather="plus"></i>
                                                        </button>
                                                    </div>
                                                    <label for="user" class="form-label">Note
                                                        :</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="note_another_dt" id="attach-another-note"
                                                            placeholder="Note">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success store-another-attach">Save</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p>{{ $info->note }}</p>
                        <div class="mt-3">
                            <label class="tx-11 fw-bolder mb-0 text-uppercase">Type:</label>
                            <p class="text-muted">{{ $info->type_attach }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- left wrapper end -->
            <div class="col-md-8 col-xl-8 middle-wrapper">
                @php
                    $no = 1;
                @endphp
                @foreach ($image as $item)
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card rounded">
                                <div class="card-body">
                                    <p class="mb-3 tx-14">{{ $item->filename }}</p>
                                    <img class="img-fluid" src="{{ asset("$item->path") }}" alt="">
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex post-actions">
                                        <form method="POST" action="{{ url("/Attach-download/en/$item->filename") }}"
                                            style="display: none;" id="download-en-img{{ $no }}">
                                        @csrf
                                        </form>
                                            <a href="javascript:;" 
                                                class="d-flex align-items-center text-muted me-4 download-img-en{{ $no }}">
                                                <i class="icon-md" data-feather="download"></i>
                                                <p class="d-none d-md-block ms-2">Download</p>
                                            </a>
                                        @if ($depart == 6)
                                            <form action="{{ route('attachment.destroy', $item->id) }}" method="POST"
                                                style="display: none;" id="delete-attach-en{{ $no }}">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="javascript:;"
                                                class="d-flex align-items-center text-muted me-4 btn-delete-attach{{ $no }}">
                                                <i class="icon-md" data-feather="trash-2"></i>
                                                <p class="d-none d-md-block ms-2">Delete</p>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </div>
            <!-- middle wrapper end -->
        </div>
    </div>
@endsection
@push('custom')
    <script>
        for (let i = 0; i < 50; i++) {
            $('.btn-delete-attach' + i + '').on('click', function() {
                Swal.fire({
                    title: 'Delete this attachment?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#delete-attach-en' + i + '').submit();
                    }
                });
            });
            $('.download-img-en' + i + '').on('click', function() {
                Swal.fire({
                    title: 'Download this file?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#download-en-img' + i + '').submit();
                    }
                });
            });
        }
        $('#add-another-file-dt').on('click', function() {
            const fileInputs = document.getElementById('file-inputs-dt');
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'files_detil[]';
            fileInput.accept = 'image/*';
            fileInput.capture = 'camera';
            fileInputs.appendChild(fileInput);
        });
        $('.store-another-attach').on('click', function() {
            if ($('#attach-another-note').val() === "" || $('#file-upload').val() === "") {
                Swal.fire({
                    title: "Files or note its still empty!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                });
            } else {
                jQuery('#form-store-another-attach').submit();
            }
        });
    </script>
@endpush
