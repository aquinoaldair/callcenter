<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolice
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        return $user->can('show-question');
    }

    public function create(User $user){
        return $user->can('create-question');
    }

    public function edit(User $user){
        return $user->can('edit-question');
    }

    public function delete(User $user){
        return $user->can('delete-question');
    }
}
