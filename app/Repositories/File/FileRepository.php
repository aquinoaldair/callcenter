<?php


namespace App\Repositories\File;


use App\Models\File;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class FileRepository extends BaseRepository
{
    public function __construct(File $model)
    {
        parent::__construct($model);
    }

    public function fillables(){
        return $this->model->getFillable();
    }

    public function deleteOptionsWhereNotIn(array $ids, $question_id){
        $files = $this->model->whereNotIn('id', $ids)
            ->where('fileable_id', $question_id)
            ->where('fileable_type', 'App\Models\Question')
            ->get();
        foreach ($files as $file){
            $file->delete();
        }
    }
}
