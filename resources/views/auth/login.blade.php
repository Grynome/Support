@extends('Theme/SignINUP/headerIn')
@section('Log')
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h4 class="font-weight-bolder text-info text-gradient">AppDesk Support HGT</h4>
                                <p class="mb-0">Enter your email and password to {{ __('Login') }}</p>
                            </div>
                            <div class="card-body">
                                @include('sweetalert::alert')
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <center>
                                    <img src="{{ asset("assets") }}/images/logo/HGT Reliable Partner logo.jpg" alt="">
                                    </center>
                                    <div class="mb-3">
                                        <label for="loginEmail" id="loginEmailLabel">{{ __('Email Address') }}</label>
                                        <input type="email" id="loginEmail" maxlength="254" placeholder="Email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus />

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-1">
                                        <label for="loginPassword" id="loginPasswordLabel">{{ __('Password') }}</label>
                                        <input type="password" id="password" placeholder="Password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password" />
                                        <div class="indicator"></div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2">
                                        <div class="pt-0 px-lg-2 px-1">
                                            <input id="showPasswordCheck" type="checkbox" onclick="ShowPass()"/>
                                            <label id="showPasswordToggle" for="showPasswordCheck">Show Password</label>
                                        </div>
                                        <div class="pt-0 px-lg-2 px-1 mt-2">
                                            <p class="text-sm mx-auto">
                                                <a href="{{ url('Register=HGT-Services') }}"
                                                    class="text-info text-gradient font-weight-bold">Forget Password?</a>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                                            in</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account?
                                    <a href="{{ url('Register=HGT-Services') }}"
                                        class="text-info text-gradient font-weight-bold">Sign
                                        up</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                style="background-image:url('{{ asset('assets-form-sign') }}/img/Untitled-2.jpg')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
