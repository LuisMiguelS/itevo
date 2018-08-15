<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Silber\Bouncer\Database\{Ability, Role};

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view', Role::class);
        $roles = Role::unless(auth()->user()->isAdmin(), function ($q){
            $q->where('name','<>',User::ROLE_ADMIN);
        })->paginate();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Role::class);
        $abilities = Ability::unless(auth()->user()->isAdmin(), function ($q){
            $q->where('name','<>','*');
        })->get();
        $role = new Role;
        return view('role.create', compact('abilities', 'role'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);
        return redirect()->route('roles.index')->with(['flash_success' => $request->createRole()]);
    }

    /**
     * Show the form for editing Role.
     *
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);
        $response = $this->canAlterThisRole($role, "No puedes editar el rol {$role->title}");
        if (!is_null($response)) {
            return $response;
        }
        $abilities = Ability::unless(auth()->user()->isAdmin(), function ($q){
            $q->where('name','<>','*');
        })->get();
        return view('role.edit', compact('role', 'abilities'));
    }

    /**
     * Update Role in storage.
     *
     * @param \App\Http\Requests\UpdateRoleRequest $request
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $response = $this->canAlterThisRole($role, "No puedes editar el rol {$role->title}");
        if (!is_null($response)) {
            return $response;
        }
        return redirect()->route('roles.index')->with(['flash_success' => $request->updateRole($role)]);
    }

    /**
     * Remove Role from storage.
     *
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $response = $this->canAlterThisRole($role, "No puedes Eliminar el rol {$role->title}");
        if (!is_null($response)) {
            return $response;
        }

        $role->delete();
        return redirect()
            ->route('roles.index')
            ->with(['flash_success' => "Rol {$role->title} eliminado correctamente."]);
    }

    protected function canAlterThisRole(Role $role, $message)
    {
        if ($role->name === User::ROLE_ADMIN || $role->name === User::ROLE_TENANT_ADMIN) {
            return redirect()
                ->route('roles.index')
                ->with(['flash_danger' => $message]);
        }
    }

}
