<?php

namespace App\Http\Controllers;

use App\Models\{Role,User};
use App\Http\Requests\UserRequest;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Crypt;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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

        $users = (new User())->getAll($search, $filter, $currentPage);
        $users->appends(['search' => $search]);

        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all(['id', 'name']);
        return view('users.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        DB::beginTransaction();

        $data = $request->validated();
        $data['role_id'] = (int) $request->role_id;
        $data['created_by'] = (int) Auth::id();
        $data['email_verified_at'] = now();

        $user = User::create($data);

        if ($user) {
            // $user->sendEmailVerificationNotification();
            DB::commit();
            session()->flash('response', ['status' => true, 'message' => 'User added successfully']);
            return back();
        }

        DB::rollBack();
        session()->flash('response', ['status' => false, 'message' => 'Failed to add user']);
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
        $roles = Role::all(['id', 'name']);
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);

        return view('users.form', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        $data = $request->validated();
        $data['role_id'] = (int) $request->role_id;

        if ($user->email != $data['email'] ) {
            $user->email = $data['email'];
            $user->email_verified_at = null;
        }

        $user->firstname = $data['name'];
        $user->contact_number = $data['contact_no'];
        $user->status = $data['status'];

        ($data['status'] == 'ACTIVE') ? $user->login_attempts = 0 : '';

        isset($request->password) ? $user->password = $data['password'] : '';

        if ($user->update($data)) {
            DB::commit();
            // ($user->email != $data['email'] ) ? $user->sendEmailVerificationNotification() : '';
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
        try {
            $id = Crypt::decrypt($id);
            DB::beginTransaction();
            $user = User::findOrFail($id);

            if ($user->delete()) {
                DB::commit();
                session()->flash('response', ['status' => true, 'message' => 'User deleted successfully']);
                return back();
            }

        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            session()->flash('response', ['status' => false, 'message' => $exception]);
            return back();
        }

    }

    public function generateCode(){
        $randString =  $randString = strtoupper(bin2hex(random_bytes(5)));
        return response()->json(['code'=>$randString]);
    }
}
