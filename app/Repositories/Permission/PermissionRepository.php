<?php


namespace App\Repositories\Permission;


use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends  BaseRepository
{

    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return $this->model->select(['id', 'name', 'title'])->get();
    }
}
