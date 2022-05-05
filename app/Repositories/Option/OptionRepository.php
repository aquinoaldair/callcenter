<?php


namespace App\Repositories\Option;


use App\Models\Option;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class OptionRepository extends BaseRepository
{
    public function __construct(Option $model)
    {
        parent::__construct($model);
    }

    public function fillables(){
        return $this->model->getFillable();
    }

    public function deleteOptionsWhereNotIn(array $ids, $question_id){
        $options = $this->model->whereNotIn('id', $ids)
            ->where('question_id', $question_id)
            ->get();
        foreach ($options as $option){
            $option->delete();
        }
    }
}
