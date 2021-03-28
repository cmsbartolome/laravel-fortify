@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body">
                    <h1 class="h4 text-gray-900 mb-4">Verify Your Email Address</h1>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('If you did not receive the email Click the button to resend again') }},
                        <br/><br/>
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('Send Verification') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
