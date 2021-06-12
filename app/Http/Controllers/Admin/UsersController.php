<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('logged-in')) {
            dd('no access allowed');
        }
        return view('admin.users.index', ['users' => User::paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create',[
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();

        $user = User::create($request->except(['_token', 'roles']));

        $user->roles()->attach($request->roles);

        request()->session()->flash('success', 'The User has been Created!');

        return redirect(route('admin.users.index'));
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
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'roles' => Role::all(),
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        request()->validate([
            'name' => 'required|max:255',
        ]);

        $user->update($request->except(['_token', 'roles', 'email', 'password']));

        $user->roles()->sync($request->roles);

        request()->session()->flash('success', 'The User has been Edited!');

        return redirect(route('admin.users.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        request()->session()->flash('success', 'The User has been Deleted!');

        return redirect(route('admin.users.index'));
    }
}
