@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('time.square') }}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-10">
                                    <h6 class="card-title">Add New Time Square</h6>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-inverse-success btn-icon-text" data-bs-toggle="modal"
                                        data-bs-target="#add-wb-product">
                                        Upload
                                        <i class="btn-icon-append" data-feather="arrow-up-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="card-title">Whats New's</h4>
                                    <textarea class="form-control" name="wn_information" id="tinymceExample" rows="10"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
<script src="{{ asset('assets') }}/vendors/tinymce/tinymce.min.js"></script>
@endpush
@push('custom-plug')
<script src="{{ asset('assets') }}/js/tinymce.js"></script>
@endpush