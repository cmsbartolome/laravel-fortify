@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input id="name" onkeydown="validateName(this.id)" onkeyup="validateName(this.id)" type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter fullname..." required autocomplete="name" autofocus>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Email Address...">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input id="password" type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, atleast 1 special characters and at least 8 or more characters" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Password...">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div id="message" class="card uo-hidden border-0 shadow-lg mb-2">
                                        <div class="p-4">
                                            <p class="pt-0 pb-0 mb-0" style="font-weight: 400; color: #1b1e21">Password must be</p>
                                            <small id="letter" class="invalid m-0">A <b>Lowercase letter</b></small><br>
                                            <small id="capital" class="invalid m-0">A <b>Uppercase letter</b></small><br>
                                            <small id="number" class="invalid m-0">A <b>Number</b></small><br>
                                            <small id="length" class="invalid m-0">Minimum of <b>8 characters</b></small><br>
                                            <small id="special" class="invalid m-0">Atleast <b>1 special character</b></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input id="password-confirm" type="password" class="form-control form-control-user" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter password...">
                                    </div>
                                    <div class="form-group">
                                        <input id="contact_no" type="text" class="form-control form-control-user @error('contact_no') is-invalid @enderror" name="contact_no"  id="contact_no" value="{{ old('contact_no') }}" onkeydown="validatePhoneNum(this.id)" onkeyup="validatePhoneNum(this.id)"required placeholder="Enter contact no...">

                                        @error('contact_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Already have an account login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/password_validator.js') }}"></script>
    <script>
        function validateName(e){
            var t=document.getElementById(e),a=/[^a-zA-Z ]/gi;t.value.search(a)>-1&&(t.value=t.value.replace(a,""))
        }

        function validatePhoneNum(e){
            var t=document.getElementById(e),a=/[^0-9]/gi;t.value.search(a)>-1&&(t.value=t.value.replace(a,""))
        }

        $('.gen-code').click(function(e){
            $(this).attr('disabled', true);
            $.get('/get-code', function(result) {
                $('#code').val(result.code);
            });
            $(this).attr('disabled', false);
        });

        $('#role').change(function (e) {
            let val = $(this).val();
            if (val == 2) {
                $('#invite-code').css('display', 'inline-block');
            } else {
                $('#code').val('');
                $('#invite-code').css('display', 'none');
            }
        });
    </script>
@endsection
