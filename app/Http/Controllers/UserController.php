<?php

namespace App\Http\Controllers;

use App\{BranchOffice, User};
use Silber\Bouncer\Database\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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
        $users = User::where('id','<>', auth()->id())
            ->unless(auth()->user()->isAdmin(), function ($user_query){
                $user_query->whereHas('roles', function ($role_query) {
                   $role_query->where([
                       ['name', '<>', User::ROLE_ADMIN],
                       ['name', '<>', User::ROLE_TENANT_ADMIN]
                   ]);
                });
            })->paginate();
        return view('user.index', compact('users'));
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
        $branchOffices = BranchOffice::select('id','name')->get();
        $roles = Role::unless(auth()->user()->isAdmin(), function ($query) {
            $query->where([
                ['name', '<>', User::ROLE_ADMIN],
                ['name', '<>', User::ROLE_TENANT_ADMIN]
            ]);
        })->get();
        return view('user.create', compact('branchOffices', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        return redirect()
            ->route('users.index')
            ->with(['flash_success' => $request->createUser()]);
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
        $this->canAlterTo($user);
        $branchOffices = BranchOffice::all();
        $roles = Role::unless(auth()->user()->isAdmin(), function ($query) {
            $query->where([
                ['name', '<>', User::ROLE_ADMIN],
                ['name', '<>', User::ROLE_TENANT_ADMIN]
            ]);
        })->get();
        return view('user.edit', compact('user', 'branchOffices', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateUserRequest $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $this->canAlterTo($user);
        return redirect()
            ->route('users.index')
            ->with(['flash_success' => $request->updateUser($user)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $this->canAlterTo($user);
        $user->delete();
        return back()
            ->with(['flash_success' => "Usuario {$user->name} eliminado con éxito."]);
    }

    /**
     * @param \App\User $user
     */
    protected function canAlterTo(User $user): void
    {
        if (! auth()->user()->isAdmin()) {
            abort_if($user->isAn(User::ROLE_ADMIN) || $user->isAn(User::ROLE_TENANT_ADMIN), 403);
        }
    }
}
