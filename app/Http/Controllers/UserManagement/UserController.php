<?php

namespace App\Http\Controllers\UserManagement;

use App\User;
use Silber\Bouncer\Database\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagement\UpdateUserRequest;
use App\Http\Requests\UserManagement\CreateUserRequest;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', User::class);
        $users = User::paginate();
        return view('user_management.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        return view('user_management.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserManagement\CreateUserRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateUserRequest $request)
    {
        $this->authorize('create', User::class);
        return back()->with(['flash_success' => $request->createUser()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', User::class);
        $roles = Role::all();
        return view('user_management.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserManagement\UpdateUserRequest $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        return redirect()->route('users.index')->with(['flash_success' => $request->updateUser($user)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return back()->with(['flash_success' => "Usuario {$user->name} eliminado con éxito."]);
    }
}
