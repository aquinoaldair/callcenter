<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleStoreRequest;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\RoleRepository;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    private $role;
    private $permission;

    public function __construct(RoleRepository $role, PermissionRepository $ability)
    {
        $this->role = $role;
        $this->permission = $ability;
    }


    public function index(){

        $this->authorize('view', Role::class);

        return Inertia::render('Admin/Role/Index', [
            "data" => $this->role->all()
        ]);
    }


    public function create()
    {
        $this->authorize('create', Role::class);

        return Inertia::render('Admin/Role/Create', [
            "permissions" => $this->permission->all()
        ]);
    }


    public function store(RoleStoreRequest $request)
    {

        $this->authorize('create', Role::class);

        $role = $this->role->create($request->only(
            $this->role->fillables()
        ));

        $this->role->assignPermissions($role, $request->permissions);

        return redirect()->route('role.index')->with('success', $this->saved_message);
    }


    public function edit($id)
    {
        $this->authorize('edit', Role::class);

        return Inertia::render('Admin/Role/Edit', [
            "role" => $this->role->find($id),
            "permissions" => $this->permission->all()
        ]);
    }


    public function update(RoleStoreRequest $request, $id)
    {
        $this->authorize('edit', Role::class);

        $role = $this->role->update($request->only(
            $this->role->fillables()
        ), $id);

        $this->role->updatePermissions($role, $request->permissions);

        return redirect()->route('role.index')->with('success', $this->updated_message);
    }


    public function destroy($id)
    {
        $this->authorize('delete', Role::class);

        return response()->json([
            "result"  => $this->role->delete($id),
            "message" => $this->deleted_message,
            "success" => true
        ], 200);
    }
}
