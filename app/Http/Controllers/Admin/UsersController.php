<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index', ['users' => User::paginate(10)]);

        /*if (Gate::allows('is-admin')) {
            return view('admin.users.index', ['users' => User::paginate(10)]);
        }*/

        /*request()->session()->flash('denied', 'You must be Admin to go there!');

        return back();*/
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
    public function store(StoreUserRequest $request)
    {
        $validatedAttributes = $request->validated();

        $validatedAttributes['password'] = Hash::make($validatedAttributes['password']);

        $user = User::create($validatedAttributes);

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
        $user->update($request->except(['_token', 'roles']));

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
