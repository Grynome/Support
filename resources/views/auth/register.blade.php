@extends('Theme/SignINUP/headerUp')
@push('customregs')
@endpush
@section('SignUp')
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('{{ asset('assets-form-sign') }}/img/curved14.jpg');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                    <p class="text-lead text-white">Silahkan daftar untuk akses AppTask Support HGT.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
            <div class="col-xl-6 col-lg-5 col-md-7 mx-auto">
                <div class="card z-index-0">
                    <div class="card-header text-center pt-4">
                        <h3>Register</h3>
                    </div>
                    <div class="card-body">
                        @include('sweetalert::alert')
                        <form role="form text-left" action="{{ url('Add/User-HGT') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="loginEmail" id="loginEmailLabel">{{ __('Full Name') }}</label>
                                        <input type="text" name="name" class="form-control" placeholder="Full Name"
                                            aria-label="Full Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="loginEmail" id="loginEmailLabel">{{ __('Username') }}</label>
                                            <label id="userCheck" style="color: red; font-size: 12px;"></label>
                                        </div>
                                        <input type="text" name="username" id="username" class="form-control" placeholder="Username"
                                            aria-label="Username" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="loginEmail" id="loginEmailLabel">{{ __('Gender') }}</label>
                                    <menu style="margin: -0.5rem 0px -0.5rem -2rem;">
                                        <input type="radio" name="gender" value="L" required>
                                        <label for="bla">
                                            <h6>Laki - laki</h6>
                                        </label>
                                        &nbsp;
                                        <input type="radio" name="gender" value="P" required>
                                        <label for="bla bla bla">
                                            <h6>Perempuan</h6>
                                        </label><br>
                                    </menu>
                                </div>
                                <div class="col-md-6">
                                    <label for="loginEmail" id="loginEmailLabel">{{ __('Work Type') }}</label>
                                    <menu style="margin: -0.5rem 0px -0.5rem -2rem;">
                                        <input type="radio" name="work_type" value="1" onChange="work_type_value = this.value; show_sp(department_value, this.value);" required>
                                        <label for="bla">
                                            <h6>Freelance</h6>
                                        </label>
                                        &nbsp;
                                        <input type="radio" name="work_type" value="2" onChange="work_type_value = this.value; show_sp(department_value, this.value);" required>
                                        <label for="bla bla bla">
                                            <h6>Karyawan</h6>
                                        </label><br>
                                    </menu>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label for="loginEmail" id="loginEmailLabel">{{ __('Email') }}</label>
                                            <label id="mailCheck" style="color: red; font-size: 12px;"></label>
                                        </div>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                                            aria-label="Email" aria-describedby="email-addon" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="example-tel-input" class="form-control-label">Phone</label>
                                            <input class="form-control" name="phone_wa" type="tel" placeholder="Phone Number Integrated with WA" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                        <label for="loginEmail" id="loginEmailLabel">{{ __('Password') }}</label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    aria-label="Password" aria-describedby="password-addon" required>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 text-center">
                                        <label>
                                            <h6>Role</h6>
                                        </label>
                                        <select class="form-control" onChange="show(this.value)" name="role" multiple
                                            required>
                                            @foreach ($role as $item)
                                                <option value="{{ $item->id }}">{{ $item->role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3 text-center" id="dept"></div>
                                </div>
                            </div>
                            <div class="row" id="regs-engineer">
                            </div>
                            <div class="form-check form-check-info text-left">
                                <input class="form-check-input" name="term_con" type="checkbox" value="Agree"
                                    id="flexCheckDefault" checked required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and
                                        Conditions</a>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" id="signUpbtn">Sign up</button>
                            </div>
                            <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                    class="text-dark font-weight-bolder">Sign in</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('customregs')
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
        function show(role){
            var dept="";
            switch(role)
            {
                case "16" : case "17" : case "18" : case "19" :{
                dept = "<label><h6>Division</h6></label><select class='form-control' onChange='show_sp(this.value, work_type_value)' id='department' name='department' multiple required>@foreach ($dept as $item)<option value='{{ $item->id }}'>{{ $item->department }}</option>@endforeach</select>";
                }
                break;        
                default :dept ="";
            }
            document.getElementById('dept').innerHTML =dept;
        };
        var work_type_value;
        function show_sp(department, work_type){
            var department_value;
            var form_input_en="";
            switch(department)
            {     
                case "6" : {
                    switch(work_type) {
                        case "1":
                        form_input_en = "<div class='col-md-6'><div class='mb-3 text-center'><label><h6>Service Point</h6></label><select class='form-control' name='sp' multiple required>@foreach ($sp as $item)<option value='{{ $item->service_id }}'>{{ $item->service_name }}</option>@endforeach</select></div></div><div class='col-md-6'><div class='mb-3 text-center'><label><h6>Chanel</h6></label><select class='form-control' name='chanel' multiple required><option value='1'>Chanel</option><option value='0'>Non-Chanel</option></select></div></div>";
                        break;
                        case "2":
                        form_input_en = "<div class='col-md-12'><div class='mb-3 text-center'><label><h6>Service Point</h6></label><select class='form-control' name='sp' multiple required>@foreach ($sp as $item)<option value='{{ $item->service_id }}'>{{ $item->service_name }}</option>@endforeach</select></div></div>";
                        break;
                        default:
                        form_input_en = "";
                    }
                }
                break;
                default :form_input_en ="";
            }
            document.getElementById('regs-engineer').innerHTML =form_input_en;
        };
    </script>
    <script>
        $(document).ready(function() {
            var $submitButton = $('#signUpbtn');
            $('#username, #email').on('blur', function() {
                var username = $('#username').val();
                var email = $('#email').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("check.UserMail") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        username: username,
                        email: email
                    },
                    success: function(response) {
                        if (response.usernameExists && response.emailExists) {
                            $('#userCheck').text('already exists.');
                            $('#mailCheck').text('already exists.');
                            $submitButton.prop('disabled', true);
                        } else if (response.usernameExists) {
                            $('#userCheck').text('already exists.');
                            $('#mailCheck').text('');
                            $submitButton.prop('disabled', true);
                        } else if (response.emailExists) {
                            $('#userCheck').text('');
                            $('#mailCheck').text('already exists.');
                            $submitButton.prop('disabled', true);
                        } else {
                            $submitButton.prop('disabled', false);
                            $('#userCheck').text('');
                            $('#mailCheck').text('');
                        }
                    }
                });
            });
        });
    </script>
@endpush
