@php
    $depart = auth()->user()->depart;
@endphp
@extends('Theme.Full-Dash.header')
@section('full-Dash')
    <div class="page-content d-flex align-items-center justify-content-center">
        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4 pe-md-0">
                            <div class="auth-side-wrapper">
                            </div>
                        </div>
                        <div class="col-md-8 ps-md-0">
                            <div class="auth-form-wrapper px-4 py-5">
                                <a href="#" class="noble-ui-logo d-block mb-2">HGT&nbsp;<span>Services</span></a>
                                <h5 class="text-muted fw-normal mb-4">Choose your log in as?</h5>
                                <form action="{{ url("Update/Dept") }}" method="post" id="fm-choose-dept">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Role</label>
                                        <select class="js-example-basic-single form-select" data-width="100%"
                                            name="val_dept" id="slc-choose-dept">
                                            <option value="">- Choose -</option>
                                            @foreach ($dept as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $depart ? 'selected' : '' }}>
                                                    {{ $item->department }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-outline-primary btn-text mb-2 mb-md-0 btn-choose-dept">
                                            Next
                                        </button>
                                    </div>
                                </form>
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
        $('.btn-choose-dept').on('click', function() {
            function getTypeValue() {
                var unit_type_id = document.getElementById("slc-choose-dept").value;
                return unit_type_id;
            };
            if (getTypeValue() == 6) {
                var dept = "Engineer";
            } else {
                var dept = "L2";
            }
            if (getTypeValue() === "") {
                Swal.fire({
                    title: "Your Role its empty!",
                    text: "Choose Your Role!",
                    icon: "warning",
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK',
                });
            } else {
                Swal.fire({
                    title: "Continue With this Role " + dept + "?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'Next',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery('#fm-choose-dept').submit();
                    }
                });
            }
            return false;
        });
    </script>
@endpush