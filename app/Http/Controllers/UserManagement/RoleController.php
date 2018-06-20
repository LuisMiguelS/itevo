<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Silber\Bouncer\Database\{Ability, Role};
use App\Http\Requests\UserManagement\CreateRoleRequest;
use App\Http\Requests\UserManagement\UpdateRoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::where('name','<>','admin')->paginate();
        return view('user_management.role.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $abilities = Ability::orderBy('name','ASC')->get();
        return view('user_management.role.create', compact('abilities'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param \App\Http\Requests\UserManagement\CreateRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRoleRequest $request)
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
        $abilities = Ability::where('name', '<>','*')->orderBy('name','ASC')->get();
        return view('user_management.role.edit', compact('role', 'abilities'));
    }

    /**
     * Update Role in storage.
     *
     * @param \App\Http\Requests\UserManagement\UpdateRoleRequest $request
     * @param \Silber\Bouncer\Database\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
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
        $role->delete();
        return redirect()->route('roles.index');
    }

}
