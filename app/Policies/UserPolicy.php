<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    
    public function view(User $user)
    {
        return $user->can('show-user');
    }

    public function create(User $user){
        return $user->can('create-user');
    }

    public function edit(User $user){
        return $user->can('edit-user');
    }

    public function delete(User $user){
        return $user->can('delete-user');
    }
}
