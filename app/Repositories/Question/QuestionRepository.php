<?php


namespace App\Repositories\Question;


use App\Models\Question;
use App\Repositories\BaseRepository;
use App\Repositories\File\FileRepository;
use App\Repositories\Option\OptionRepository;

class QuestionRepository extends BaseRepository
{
    private $option;
    private $file;

    public function __construct(Question $model, OptionRepository $option, FileRepository $file)
    {
        parent::__construct($model);
        $this->option = $option;
        $this->file = $file;
    }

    public function fillables(){
        return $this->model->getFillable();
    }

    public function storeOptions(Question $question, array $options){
        foreach ($options as $option){
            $question->options()->create($option);
        }
    }

    public function storeFiles(Question $question, $files){
        if (gettype($files) === "array" ){
            foreach ($files as $file){
                $question->files()->create([
                    'path' => $file["path"],
                    'extension' => isset($file["extension"]) ? $file["extension"] : null
                ]);
            }
        }
    }

    public function updateOptions(Question $question, array $options){
        //servira para eliminar las opciones que no vengan en el array pero que si existan en la abse de datos
        $options_id = [];

        foreach ($options as $option){
            //actualizar existente
            if (isset($option["id"])){
                $this->option->update([
                    'next_question_id' => $option['next_question_id'],
                    'name'             => $option['name']
                ], $option["id"]);
                $options_id[] =  $option["id"];
            }else{
                //crear nuevo
                $item = $this->option->create([
                    'next_question_id' => $option['next_question_id'],
                    'name'             => $option['name'],
                    'question_id'       => $question->id
                ]);
                $options_id[] =  $item->id;
            }
            //eliminar las opciones de la pregunta que se eliminaron en el front
        }
        $this->option->deleteOptionsWhereNotIn($options_id, $question->id);
    }

    public function updateFiles(Question $question, array $files){
        $files_id = [];

        foreach ($files as $file){
            if (isset($file["id"])){
                $files_id[] = $file["id"];
            }else{
                $item = $question->files()->create([
                    'path' => $file["path"],
                    'extension' => isset($file["extension"]) ? $file["extension"] : null
                ]);
                $files_id[] =  $item->id;
            }
        }
        $this->file->deleteOptionsWhereNotIn($files_id, $question->id);
    }


    public function getByScript($script_id){
        return $this->model->with('options')
            ->with('files')
            ->where('script_id', $script_id)
            ->orderBy('first', 'desc')
            ->get();
    }
}
