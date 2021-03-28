@extends('layouts.admin')

@section('title')
    {{ (isset($user)) ? 'Update' : 'Create' }} User
@endsection

@section('content')
    <div class="row">
        @include('elements.general-alert')
        <div class="col-md-12">
            <h3 ><b>{{ (isset($user)) ? 'Update' : 'Create' }} User</b></h3>
            <div class="card o-hidden border-0 shadow-lg my-2" >
                <div class="card-body">
                    @if(isset($user))
                        <form method="POST" action="/users/{{ Crypt::encrypt($user->id) ?? '' }}" >
                            @method('PATCH')
                    @else
                        <form method="POST" action="/users" >
                            <input type="hidden" name="type" value="new">
                    @endif
                                    @csrf()
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Fullname</label>
                                                <input type="text" name="name" id="name" class="form-control" onkeydown="validateName(this.id)" onkeyup="validateName(this.id)" value="{{ $user->name ?? old('name')}}" required >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}"required >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact no.</label>
                                                <input type="text" name="contact_no" class="form-control" id="contact_no" value="{{ $user->contact_no ?? old('contact_no') }}" onkeydown="validatePhoneNum(this.id)" onkeyup="validatePhoneNum(this.id)" required >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" name="status" required>
                                                    <option selected disabled>Please choose status</option>
                                                    @foreach(config('constant.user_status') as $key => $value)
                                                        <option value="{{ $key }}" {{ ( $key == old('status') || (isset($user)) && $key == $user->status ) ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input id="password" type="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control" name="password" autocomplete="off" minlength="8">
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
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                                <span id="msg" class="text-danger text-small"><b>Confirm password do not match</b></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>User role</label>
                                                <select class="form-control" name="role_id" id="role" required>
                                                    <option selected disabled>Please choose user role</option>
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}" {{ ( $role->id == old('role_id') || (isset($user)) && $role->id == $user->role_id ) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div id="invite-code" class="col-md-4" style="display: {{ (old('code') === 2 || (isset($user->code))) ? 'inline-block' : 'none' }};">
                                            <label for="password-confirm">Invite Code</label><br/>
                                            <div class="form-group input-group" >
                                                <input id="code" type="text" class="form-control" name="code" value="{{ (isset($user)) ? $user->code : old('code') }}" autocomplete="off" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="input-group-text btn btn-primary btn-sm gen-code">Generate code</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn float-right bg-classic text-light" type="submit" >{{ (isset($user)) ? 'Update' : 'Save' }}</button>
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
