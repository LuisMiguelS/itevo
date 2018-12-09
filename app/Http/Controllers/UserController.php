<?php

namespace App\Http\Controllers;

Use Bouncer;
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

        $users = User::unless(auth()->user()->isSuperAdmin(), function ($query) {
            $query->unless(auth()->user()->isAdmin(), function ($query_not_admin) {
                $query_not_admin->whereHas('branchOffices', function ($branchOffice_query) {
                    $branchOffice_query->whereHas('users', function ($q) {
                        $q->where('user_id', auth()->id());
                    });
                });
            });
        })->paginate();

        return view('user.index', compact('users'));
    }

    /**
     * Create the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $branchOffices = BranchOffice::unless(auth()->user()->isAdmin(), function ($query) {
            $query->whereHas('users', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->select('id','name')->get();

        $roles = Role::unless(auth()->user()->isAdmin(), function ($query) {
            $query->where([
                ['name', '<>', User::ROLE_ADMIN],
                ['name', '<>', User::ROLE_TENANT_ADMIN]
            ]);
        })->get();
        $user = new User;
        return view('user.create', compact('branchOffices', 'roles', 'user'));
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
     * Edit the form for editing the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        Bouncer::refresh();

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
        abort_if(auth()->id() === $user->id,403);

        if (! auth()->user()->isSuperAdmin()) {
            abort_if($user->isAn(User::ROLE_ADMIN) || $user->isAn(User::ROLE_TENANT_ADMIN), 403);
        }
    }
}
