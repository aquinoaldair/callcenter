<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    private $user;
    private $role;

    public function __construct(UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index(){
        $this->authorize('view', User::class);

        //return $this->user->get();
        return Inertia::render('Admin/User/Index', [
            "data" => $this->user->get()
        ]);
    }

    public function create()
    {
        $this->authorize('create', User::class);

        return Inertia::render('Admin/User/Create', [
            "roles" => $this->role->all()
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $user = $this->user->create($request->only(
            $this->user->fillables()
        ));

        $this->user->assignPermissions($user, $request->permissions);

        return redirect()->route('user.index')->with('success', $this->saved_message);
    }


    public function edit($id)
    {
        $this->authorize('edit', User::class);

        return Inertia::render('Admin/User/Edit',[
            "roles" => $this->role->all(),
            "user" => $this->user->withRoleAndPermissions($id)
        ]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $this->authorize('edit', User::class);

        $this->user->update($request->only(
            $this->user->fillables()
        ), $id);

        $user = $this->user->find($id);

        $this->user->assignPermissions($user, $request->permissions);

        return redirect()->route('user.index')->with('success', $this->saved_message);
    }

    public function destroy($id)
    {
        $this->authorize('delete', User::class);

        return response()->json([
            "result" => $this->user->delete($id),
            "message" => "Success deleted",
            "success" => true
        ], 200);
    }
}
