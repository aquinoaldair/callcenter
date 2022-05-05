<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScriptPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->can('show-script');
    }

    public function create(User $user){
        return $user->can('create-script');
    }

    public function edit(User $user){
        return $user->can('edit-script');
    }

    public function delete(User $user){
        return $user->can('delete-script');
    }
}
