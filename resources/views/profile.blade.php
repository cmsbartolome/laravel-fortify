@extends('layouts.admin')

@section('content')
<div class="row">
    @include('elements.general-alert')
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body">
                <form class="user" method="post" action="{{ route('update-profile') }}">
                    @csrf
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Fullname') }}</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter fullname..." onkeydown="validateName(this.id)" onkeyup="validateName(this.id)" value="{{ auth()->user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Email Address') }}</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email address..." value="{{ auth()->user()->email }}" required fccus>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Password') }}</label>
                        <input id="password" type="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control" name="password" autocomplete="new-password" minlength="8">
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
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                        <span id="msg" class="text-danger text-small"><b>Confirm password do not match</b></span>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">{{ __('Contact Number') }}</label>
                        <input type="text" name="contact_no" class="form-control" id="contact_no" value="{{ auth()->user()->contact_no ?? old('contact_no') }}" onkeydown="validatePhoneNum(this.id)" onkeyup="validatePhoneNum(this.id)" required >
                    </div>
                    <button class="btn bg-classic text-light float-right" type="submit" >{{ (isset($user)) ? 'Update' : 'Save' }}</button>
                </form>
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
</script>
@endsection
