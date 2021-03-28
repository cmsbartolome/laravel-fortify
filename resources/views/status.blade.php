@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body">
                    @switch(session()->get('response.status'))
                    @case(true)
                        <p class="text-info"><span class="fa fa-info-circle"></span> You may close this window and continue to login in the mobile app.</p>
                        @break
                    @case(false)
                        <p class="text-danger"><span class="fa fa-info-circle"></span> Email verification failed.</p>
                        @break
                    @endswitch
                    @include('elements.general-alert')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
