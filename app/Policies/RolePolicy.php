<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;


    public function view(User $user)
    {
        return $user->can('show-role');
    }

    public function create(User $user){
        return $user->can('create-role');
    }

    public function edit(User $user){
        return $user->can('edit-role');
    }

    public function delete(User $user){
        return $user->can('delete-role');
    }
}
