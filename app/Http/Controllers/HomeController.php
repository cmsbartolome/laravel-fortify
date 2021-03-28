<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\UserRequest;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = [
            'users' => (new User())->totalUsers(),
            'roles' => (new Role())->totalRoles()
        ];
        return view('home', compact('data'));
    }

    public function updateProfile(UserRequest $request) {
        DB::beginTransaction();
        $user = auth()->user()->update($request->validated());

        if ($user) {
            DB::commit();
            session()->flash('response', ['status' => true, 'message' => 'Updated successfully']);
            return back();
        }

        DB::rollBack();
        session()->flash('response', ['status' => false, 'message' => 'Failed to add update']);
        return back();
    }
}
