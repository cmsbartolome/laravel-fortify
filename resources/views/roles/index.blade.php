@extends('layouts.admin')

@section('title')
    Roles
@endsection

@section('content')
    <div class="row">
        @include('elements.general-alert')
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9">
                    <h3 class="mt-0"><b>Roles</b></h3>
                </div>
                <div class="col-md-3">
                    <a href="/roles/create"  class="btn float-right  bg-classic text-light"><span class="fa fa-plus"></span></a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="">
                                <form method="get" action="/roles?" >
                                    <input type="text" class="form-control form-control mb-2  " placeholder="Search any keyword" name="search" >
                                    <span style="font-size: 14px;">Please <b>"PRESS"</b> Enter to search</span>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="/users"><button class="btn btn-dark ml-2 pull-right">Refresh Table</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card o-hidden border-0 shadow-lg my-3" >
                <div class="table table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $count = ($roles->currentpage()-1)* $roles->perpage() + 1; // continues row count
                        @endphp
                        @forelse($roles as $role)
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ ucfirst($role->name) ?? '' }}</td>
                                <td>{{ $role->slug ?? '' }}</td>
                                <td>{{ $role->description ?? '' }}</td>
                                <td width="10%" >
                                    <div class="d-inline-flex">
                                        <a href="/roles/{{ Crypt::encrypt($role->id) }}/edit" ><button class="btn btn-info btn-sm mr-2">EDIT</button></a>
                                        <form method="POST" action="/roles/{{ Crypt::encrypt($role->id) }}" id="form-{{ $role->id }}">
                                            @method('DELETE')
                                            @csrf()
                                            <button data-id="{{ $role->id }}" data-name="{{ $role->name }}" type="button" name="delete"  class="btn btn-danger btn-sm delete">
                                                DELETE
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <table style="width:100%">
                                    <tr>
                                        <center>No record found</center>
                                    </tr>
                                </table>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="display: table;" class="float-right" >
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-center"><strong>Are you sure to delete "<span class="name"></span>" record?</strong></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger on_confirm">Confirm</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.delete').each(function(index, value) {
            $(this).on('click', function () {
                $('#deleteModal').modal('show');
                let key = $(this).data('id');
                let name = $(this).data('name');

                $('.name').html(name);

                $('.on_confirm').on('click', function () {
                    $('#form-'+key).submit();
                    //$(this).attr('disabled', true);
                });

            });
        });
    </script>
@endsection
