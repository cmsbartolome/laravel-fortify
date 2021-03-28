<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentPage = request()->get('page') ? request()->get('page') : 1;
        $search = (string) e(request()->search) ?? null;
        $filter =  request()->filter ?? null;

        $roles = (new Role())->getAll($search, $filter, $currentPage);
        $roles->appends(['search' => $search]);

        return view('roles.index', compact(['roles']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();

        $rq = $request->validated();
        $rq['slug'] =  Str::slug($request->name);

        $role = Role::create($rq);

        if ($role) {
            DB::commit();
            session()->flash('response', ['status' => true, 'message' => 'Role added successfully']);
            return back();
        }

        DB::rollBack();
        session()->flash('response', ['status' => false, 'message' => 'Failed to add role']);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $role = Role::findOrFail($id);

        return view('roles.form', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        DB::beginTransaction();
        $id = Crypt::decrypt($id);
        $user = Role::findOrFail($id);

        $rq = $request->validated();
        $rq['slug'] =  Str::slug($request->name);

        if ($user->update($rq)) {
            DB::commit();
            session()->flash('response', ['status' => true, 'message'=>'Updated successfully']);
            return back();
        }

        DB::rollBack();
        session()->flash('response', ['status' => false, 'message'=>'Update failed']);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $id = Crypt::decrypt($id);
        $role = Role::findOrFail($id);

        if ($role->delete()) {
            DB::commit();
            session()->flash('response', ['status' => true, 'message' => 'Role deleted successfully']);
            return back();
        }

        DB::rollBack();
        session()->flash('response', ['status' => false, 'message' => 'Unable to delete role']);
        return back();
    }
}
