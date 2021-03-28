@extends('layouts.admin')

@section('title')
    {{ (isset($role)) ? 'Update' : 'Create' }} Role
@endsection

@section('content')
    <div class="row">
        @include('elements.general-alert')
        <div class="col-md-12">
            <h3><b>{{ (isset($role)) ? 'Update' : 'Create' }} Role</b></h3>
            <div class="card o-hidden border-0 shadow-lg my-2" >
                <div class="card-body">
                    @if(isset($role))
                        <form method="POST" action="/roles/{{ Crypt::encrypt($role->id) ?? '' }}" >
                            @method('PATCH')
                            @else
                                <form method="POST" action="/roles" >
                                    @endif
                                    @csrf()
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Role name</label>
                                                <input type="text" name="name" id="name" class="form-control" onkeydown="validateName(this.id)" onkeyup="validateName(this.id)" value="{{ $role->name ?? old('name')}}" required >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description" id="description" required>{{ $role->description ?? old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn float-right bg-classic text-light" type="submit" >{{ (isset($role)) ? 'Update' : 'Save' }}</button>
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
    </script>
@endsection
