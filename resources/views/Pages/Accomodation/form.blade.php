@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Form / Partner</a></li>
                @if (empty($data_ptn))
                    <li class="breadcrumb-item active" aria-current="page">Add New Data Partner</li>
                @else
                    <li class="breadcrumb-item active" aria-current="page">Edit Data Partner</li>
                @endif
            </ol>
        </nav>
        <form class="forms-sample" action="{{ empty($data_ptn) ? url('Add/data=Partner') : url("update/$id/data=Partner") }}"
            method="post" id="form-partner">
            @csrf
            @if (!empty($data_ptn))
                {{ method_field('patch') }}
            @endif
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Partner Info</h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="Partner Name" class="form-label">Partner Name</label>
                                                    <input id="partner-name" class="form-control" name="partner_name"
                                                        type="text" placeholder="Type Partner Name"
                                                        value="{{ @$data_ptn->partner }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Contact Person" class="form-label">Contact Person</label>
                                                    <input id="contact-person" class="form-control" name="cp_partner"
                                                        type="text" placeholder="Type Contact Person"
                                                        value="{{ @$data_ptn->contact_person }}">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                        <label class="form-label">Address</label>
                                                        <textarea class="form-control" name="address_partner" id="adds-partner" maxlength="150" rows="3" placeholder="Type Address">{{ @$data_ptn->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="Phone" class="form-label">Phone</label>
                                                    <input class="form-control mb-4 mb-md-0" id="phone-partner"
                                                        data-inputmask-alias="(+62) 999-9999-9999" name="phone_partner"
                                                        value="{{ @$data_ptn->telp }}" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="Email" class="form-label">Email</label>
                                                    <input class="form-control mb-4 mb-md-0" name="email_partner"
                                                        id="mail-partner" data-inputmask="'alias': 'email'"
                                                        value="{{ @$data_ptn->email }}" />
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
        </form>
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <button type="button"
                                    class="btn btn-inverse-primary btn-icon-text btn-sm btn-store-partner">
                                    Save
                                    <i class="btn-icon-append" data-feather="save"></i>
                                </button>
                            </div>
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
        // function onChangeSelectPartner(url, id, name) {
        //     $.ajax({
        //         url: url,
        //         type: 'GET',
        //         data: {
        //             id: id
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             var options = '<option value="">- Select Option -</option>';
        //             for (var key in data) {
        //                 var selected = "";
        //                 if (name == 'cities-partner') {
        //                     if (key == '{{ @$data_ptn->cities }}') {
        //                         selected = "selected";
        //                     }
        //                 } else if (name == 'districts-partner') {
        //                     if (key == '{{ @$data_ptn->districts }}') {
        //                         selected = "selected";
        //                     }
        //                 } else if (name == 'villages-partner') {
        //                     if (key == '{{ @$data_ptn->villages }}') {
        //                         selected = "selected";
        //                     }
        //                 }
        //                 options += '<option value="' + key + '" ' + selected + '>' + data[key] + '</option>';
        //             }
        //             $('#' + name).html(options);
        //         }
        //     });
        // }

        // $(function() {
        //     var isEditForm = '{{ !empty($data_ptn) }}'; // check if the form is for editing or adding new data

        //     // form is for editing
        //     $('#provinces-partner').on('change', function() {
        //         onChangeSelectPartner('{{ route('cities') }}', $(this).val(), 'cities-partner');
        //         $('#districts-partner').html('<option value="">- Select Option -</option>');
        //         $('#villages-partner').html('<option value="">- Select Option -</option>');
        //     });

        //     $('#cities-partner').on('change', function() {
        //         onChangeSelectPartner('{{ route('districts') }}', $(this).val(), 'districts-partner');
        //         $('#villages-partner').html('<option value="">- Select Option -</option>');
        //     });

        //     $('#districts-partner').on('change', function() {
        //         onChangeSelectPartner('{{ route('villages') }}', $(this).val(), 'villages-partner');
        //     });

        //     if (isEditForm) {
        //         if ('{{ @$data_ptn->provinces }}' != '') {
        //             $('#provinces-partner').val('{{ @$data_ptn->provinces }}');
        //             onChangeSelectPartner('{{ route('cities') }}', '{{ @$data_ptn->provinces }}',
        //                 'cities-partner');
        //             $('#districts-partner').val('{{ @$data_ptn->districts }}');
        //             onChangeSelectPartner('{{ route('districts') }}', '{{ @$data_ptn->cities }}',
        //                 'districts-partner');
        //             $('#villages-partner').val('{{ @$data_ptn->villages }}');
        //             onChangeSelectPartner('{{ route('villages') }}', '{{ @$data_ptn->districts }}',
        //                 'villages-partner');
        //         }
        //     } else {
        //         $('#provinces-partner').on('change', function() {
        //             onChangeSelectPartner('{{ route('cities') }}', $(this).val(), 'cities-partner');
        //         });
        //         $('#cities-partner').on('change', function() {
        //             onChangeSelectPartner('{{ route('districts') }}', $(this).val(), 'districts-partner');
        //         });
        //         $('#districts-partner').on('change', function() {
        //             onChangeSelectPartner('{{ route('villages') }}', $(this).val(), 'villages-partner');
        //         });
        //     }
        // });
    </script>
@endpush