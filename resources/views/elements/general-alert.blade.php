@if (session()->has('response'))

    <div class="col-md-12">
        <div class="alert {{ session()->get('response.status') ? 'text-success' : 'text-danger' }} alert{{ session()->get('response.status') ? '-success ' : '-danger' }}" >
            {{session()->get('response.message')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

@endif

<div class="col-md-12">
    @if ($errors->all())
        <div class="alert alert-danger text-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $err_message)
                    <li>{!!$err_message!!}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
