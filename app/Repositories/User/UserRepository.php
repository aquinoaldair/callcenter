<?php


namespace App\Repositories\User;


use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function get()
    {
        return $this->model->with('role')->get()->except([Auth::id(), 1]);
    }

    public function find($id)
    {
        return $this->model->with('role')->find($id);
    }

    public function withRoleAndPermissions($id){
        return $this->model->with('role')->with('permissions')->find($id);
    }

    public function assignRole($user, $role){
        $user->syncRoles([$role]);
    }
    public function assignPermissions($user, $permissions){
        $user->syncPermissions($permissions);
    }


    public function fillables(){
        return $this->model->getFillable();
    }
}
