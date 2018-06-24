<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\User;
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
     */
    public function index()
    {
        $roles = Role::unless(auth()->user()->isAdmin(), function ($q){
            $q->where('name','<>',User::ROLE_ADMIN);
        })->paginate();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $abilities =  Ability::unless(auth()->user()->isAdmin(), function ($q){
            $q->where('name','<>','*');
        })->get();
        return view('role.create', compact('abilities'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param \App\Http\Requests\StoreRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        return redirect()->route('roles.index')->with(['flash_success' => $request->createRole()]);
    }

    /**
     * Show the form for editing Role.
     *
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if ($role->name === User::ROLE_ADMIN || $role->name === User::ROLE_TENANT_ADMIN) {
            return redirect()
                ->route('roles.index')
                ->with(['flash_danger' => "No puedes editar el rol {$role->title}"]);
        }

        $abilities =  Ability::unless(auth()->user()->isAdmin(), function ($q){
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
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        if ($role->name === User::ROLE_ADMIN || $role->name === User::ROLE_TENANT_ADMIN) {
            return redirect()
                ->route('roles.index')
                ->with(['flash_danger' => "No puedes editar el rol {$role->title}"]);
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
        if ($role->name === User::ROLE_ADMIN || $role->name === User::ROLE_TENANT_ADMIN) {
            return redirect()
                ->route('roles.index')
                ->with(['flash_danger' => "No puedes Eliminar el rol {$role->title}"]);
        }

        $role->delete();
        return redirect()
            ->route('roles.index')
            ->with(['flash_success' => "Rol {$role->title} eliminado correctamente."]);
    }

}
