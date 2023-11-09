@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="position-relative mb-3">
                        <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                            <img src="https://via.placeholder.com/1560x370"class="rounded-top" alt="profile cover">
                        </figure>
                        <div
                            class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                            <div>
                                <img class="rounded-circle profile-user" src="{{asset("$profile->profile")}}" alt="profile">
                                <span class="h4 ms-3 text-dark">{{ $profile->full_name }} ~
                                    {{ @$profile->dept->department }}</span>
                            </div>
                            <div class="d-none d-md-block">
                                <button class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#edit-profile">
                                    <i data-feather="edit" class="btn-icon-prepend"></i> Edit profile
                                </button>
                                <div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="slaModalLabel"
                                    aria-hidden="true" data-bs-backdrop="static">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="slaModalLabel">Upload Profile
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <form id="upload-img-user"
                                                        action="{{ url('Add-Image/User') }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-md-12 mb-3 text-center">
                                                            <h6 class="card-title">Profile</h6>
                                                            <div class="image-upload">
                                                                <a href="javascript:;" class="mdi mdi-close mdi-24px"
                                                                    onclick="resetImage()"></a>
                                                                <div id="imageUpload" class="fileupload-image">
                                                                    <input type="file" name="profile_file" onchange="previewFile()"
                                                                        title="Upload Foto Profile">
                                                                    <i class="mdi mdi-camera mdi-24px"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <h6 class="card-title">Cover</h6>
                                                            <input type="file" name="cover_file" id="DropifyCover" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success btn-upload-user">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form action="{{ route('update.user', $profile->full_name) }}" method="POST"
                                    id="update-user">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label for="ServicePoint" class="form-label">Full Name</label>
                                            <input class="form-control" name="fn_user" type="text"
                                                value="{{ $profile->full_name }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="ServicePoint" class="form-label">Username</label>
                                            <input class="form-control" name="un_user" type="text"
                                                value="{{ $profile->username }}">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Phone" class="form-label">Phone</label>
                                            <input class="form-control mb-4 mb-md-0"
                                                data-inputmask-alias="(+62) 999-9999-9999" name="phone_user" id="phone-user"
                                                value="{{ substr($profile->phone, 1) }}" />
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Email" class="form-label">Email</label>
                                            <input class="form-control mb-4 mb-md-0" name="mail_user"
                                                data-inputmask="'alias': 'email'" value="{{ $profile->email }}" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-inverse-success save-biodata"> Edit </button>
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
        function previewFile() {
            var imageUpload = document.querySelector('#imageUpload'),
                file = document.querySelector('input[type="file"]').files[0],
                reader = new FileReader();
            reader.onloadend = () => imageUpload.style.backgroundImage = 'url(' + reader.result + ')'
            if (file)
                reader.readAsDataURL(file)
            else
                imageUpload.style.backgroundImage = ''

            document.getElementById('upload-bg').reset()
        }

        function resetImage() {
            document.getElementById('imageUpload').style.backgroundImage = '';
        }
    </script>
    <script>
        $('.save-biodata').on('click', function() {
            swal.fire({
                title: "Continues update!?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: '#34a853',
                confirmButtonText: 'Yes!',
                cancelButtonColor: '#d33',
                cancelButtonText: "No!"
            }).then((result) => {
                if (result.isConfirmed) {
                    jQuery('#update-user').submit();
                }
            });
        });
        $('.btn-upload-user').on('click', function() {
            jQuery('#upload-img-user').submit();
        });
    </script>
@endpush
