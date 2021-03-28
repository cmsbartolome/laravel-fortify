@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="h4 text-gray-900 mb-4 text-center">Reset Password</h1>
                    <form class="user" method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ $request->email ?? old('email') }}" required autocomplete="email" readonly autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input id="password" type="password" placeholder="Enter new password..." class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div id="message" class="card uo-hidden border-0 shadow-lg mb-2">
                            <div class="p-4">
                                <p class="pt-0">Password guidelines</p>
                                <small id="letter" class="invalid m-0">A <b>Lowercase letter</b></small><br>
                                <small id="capital" class="invalid m-0">A <b>Uppercase letter</b></small><br>
                                <small id="number" class="invalid m-0">A <b>Number</b></small><br>
                                <small id="length" class="invalid m-0">Minimum of <b>8 characters</b></small><br>
                                <small id="special" class="invalid m-0">Atleast <b>1 special character</b></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <input id="password-confirm" type="password" placeholder="Re enter new password..." class="form-control form-control-user" name="password_confirmation" required autocomplete="new-password">
                            <span id="msg" class="text-danger text-small"><b>Confirm password do not match</b></span>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('/js/password_validator.js') }}"></script>
@endsection
