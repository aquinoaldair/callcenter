<?php


namespace App\Repositories\Script;


use App\Models\Script;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ScriptRepository extends BaseRepository
{
    public function __construct(Script $model)
    {
        parent::__construct($model);
    }

    public function fillables(){
        return $this->model->getFillable();
    }
}
