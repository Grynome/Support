<!DOCTYPE html>
<html lang="en">
@include('Theme/Sub/head')
@php
    $name = auth()->user()->full_name;
    $verify = auth()->user()->verify;
    $profile = auth()->user()->profile;
@endphp

<body>
    @if ($verify != 1)
        <form action="{{ url('logout') }}" method="POST" id="log_out">
            {{ csrf_field() }}
        </form>
        @push('custom')
            <script>
                var getLink = $(this).attr('href');
                Swal.fire({
                    title: "Your account has not been verified!!",
                    text: "Pls Call Developer Contact Person!",
                    icon: 'error',
                    allowOutsideClick: false,
                    showCancelButton: false,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Back'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = getLink;
                        jQuery("#log_out").submit();
                    }
                });
            </script>
        @endpush
    @else
        <div class="main-wrapper">
            @include('sweetalert::alert')
            @include('Theme/Sub/sidebar')
            <nav class="settings-sidebar">
                <div class="sidebar-body">
                    <a href="#" class="settings-sidebar-toggler">
                        <i data-feather="settings"></i>
                    </a>
                    <div class="theme-wrapper">
                        <h6 class="text-muted mb-2">Light Theme:</h6>
                        <a class="theme-item" href="javascript:;">
                            <img src="../assets/images/screenshots/light.jpg" alt="light theme">
                        </a>
                        <h6 class="text-muted mb-2">Dark Theme:</h6>
                        <a class="theme-item active" href="javascript:;">
                            <img src="../assets/images/screenshots/dark.jpg" alt="light theme">
                        </a>
                    </div>
                </div>
            </nav>
            <div class="page-wrapper">
                <!-- partial:partials/_navbar.html -->
                <nav class="navbar">
                    <a href="#" class="sidebar-toggler">
                        <i data-feather="menu"></i>
                    </a>
                    <div class="navbar-content">
                        <div class="table center">
                            <div class="monitor-wrapper center">
                                <div class="monitor center">
                                    @if ($wn_cn != 0)
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                viewBox="0 0 30 30">
                                                <path fill="currentColor"
                                                    d="M4 2h16a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2m2 4v4h4v2H8v6h2v-2h4v2h2v-6h-2v-2h4V6h-4v4h-4V6H6Z" />
                                            </svg>: {{ $wn_cn }} New information in
                                            <a href="{{ url('/') }}">Time's
                                                Square
                                            </a>, check it out!
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown"
                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="bell"></i>
                                    @if ($unread != 0)
                                        <div class="indicator">
                                            <div class="circle"></div>
                                        </div>
                                    @endif
                                </a>
                                <div class="dropdown-menu p-0" aria-labelledby="notificationDropdown">
                                    <div
                                        class="px-3 py-2 d-flex align-items-center justify-content-between border-bottom">
                                        @if (!empty($val_notif))
                                            <p>{{ $unread }} Unread Notif</p>
                                            @if ($unread >= 2)
                                                <a href="javascript:;" class="text-muted">Clear all</a>
                                            @endif
                                        @else
                                            <p>No Notification</p>
                                        @endif
                                    </div>
                                    @foreach ($notif as $item)
                                        <div class="p-1">
                                            @if ($item->bagian == 'Ticket')
                                                @php
                                                    $url = "Detail/Ticket=$item->kunci";
                                                @endphp
                                            @endif
                                            @if ($item->see == 0)
                                                <a href="{{ url("$url") }}"
                                                    class="dropdown-item d-flex align-items-center"
                                                    style="background-color:rgba(101, 113, 255, 0.1)">
                                                @else
                                                    <a href="javascript:;"
                                                        class="dropdown-item d-flex align-items-center">
                                            @endif
                                            <div class="px-3 d-flex align-items-center justify-content-center">
                                                <p>{{ $item->user_from }} :&nbsp;</p>
                                            </div>
                                            <div class="flex-grow-1 me-2">
                                                <p>{{ $item->note }}</p>
                                                <p class="tx-12 text-muted dif-selisih-waktu"
                                                    data-datetime="{{ $item->send_at }}"></p>
                                            </div>
                                            </a>
                                        </div>
                                    @endforeach
                                    @if (!empty($val_notif))
                                        @if ($unread >= 2)
                                            <div
                                                class="px-3 py-2 d-flex align-items-center justify-content-center border-top">
                                                <a href="javascript:;">Read all</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="wd-30 ht-30 rounded-circle" src="{{ asset("$profile") }}"
                                        alt="profile">
                                </a>
                                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                                        <div class="mb-3">
                                            <img class="wd-80 ht-80 rounded-circle" src="{{ asset("$profile") }}"
                                                alt="">
                                        </div>
                                        <div class="text-center">
                                            <p class="tx-16 fw-bolder">{{ auth()->user()->username }}</p>
                                            <p class="tx-12 text-muted">{{ auth()->user()->email }}</p>
                                        </div>
                                    </div>
                                    <ul class="list-unstyled p-1">
                                        <a href="{{ url("Profile/$name") }}" class="text-body ms-0">
                                            <li class="dropdown-item py-2">
                                                <i class="me-2 icon-md" data-feather="user"></i>
                                                <span>Profile</span>
                                            </li>
                                        </a>
                                        <a href="#reset-pwd" class="text-body ms-0" data-bs-toggle="modal">
                                            <li class="dropdown-item py-2">
                                                <i class="me-2 icon-md" data-feather="repeat"></i>
                                                <span>Reset Password</span>
                                            </li>
                                        </a>
                                        <form action="{{ url('logout') }}" method="POST" id="formLog"
                                            style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                        <a href="javascript:;" class="text-body ms-0 log-out">
                                            <li class="dropdown-item py-2">
                                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                                <span>Log Out</span>
                                            </li>
                                        </a>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <div class="modal fade" id="reset-pwd" tabindex="-1" aria-labelledby="sourceModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="sourceModalLabel">Reset Password
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="btn-close"></button>
                            </div>
                            <form action="{{ route('reset.password', $name) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="password">New Password</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="new-password">
                                                <div class="invalid-feedback">Please provide a new password.</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="password-confirm">Confirm New Password</label>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password">
                                                <div class="invalid-feedback">Please confirm your new password.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success" disabled>Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- partial -->
                @yield('getPage')
                @push('custom')
                    <script>
                        const passwordInput = document.getElementById('password');
                        const passwordConfirmInput = document.getElementById('password-confirm');
                        const confirmPasswordError = document.querySelector('#password-confirm + .invalid-feedback');
                        const saveButton = document.querySelector('.btn-success');

                        function validatePassword() {
                            if (passwordInput.value !== passwordConfirmInput.value) {
                                passwordConfirmInput.setCustomValidity("Passwords do not match.");
                                passwordConfirmInput.classList.add("is-invalid");
                                confirmPasswordError.style.display = "block";
                                saveButton.disabled = true;
                            } else {
                                passwordConfirmInput.setCustomValidity("");
                                passwordConfirmInput.classList.remove("is-invalid");
                                confirmPasswordError.style.display = "none";
                                saveButton.disabled = false;
                            }
                        }

                        passwordInput.addEventListener('input', validatePassword);
                        passwordConfirmInput.addEventListener('input', validatePassword);
                    </script>
                @endpush
                @extends('Theme/footer')
    @endif
