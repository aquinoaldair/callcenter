<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Question;
use App\Repositories\Option\OptionRepository;
use App\Repositories\Question\QuestionRepository;
use App\Repositories\Script\ScriptRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class QuestionController extends Controller
{

    private $script;
    private $question;
    private $option;

    public function __construct(ScriptRepository $script, QuestionRepository $question, OptionRepository $option)
    {
        $this->script = $script;
        $this->question = $question;
        $this->option = $option;
    }

    public function index($script_id)
    {
        $this->authorize('view', Option::class);

        return Inertia::render('Admin/Question/Index', [
            "data"     => $this->question->all(),
            "script"   => $this->script->find($script_id)
        ]);
    }


    public function getByScript($script_id){
        $questions =  $this->question->getByScript($script_id);

        return response()->json([
            "questions"      => $questions,
            "message"   => $this->saved_message
        ], 200);
    }


    public function store(Request $request)
    {
        $this->authorize('create', Option::class);

        $question = $this->question->create($request->only(
            $this->question->fillables()
        ));

        $this->question->storeOptions($question, $request->get('options'));

        $this->question->storeFiles($question, $request->get('files'));

        return response()->json([
            "data"      => $question,
            "message"   => $this->saved_message
        ], 200);
    }


    public function update($script_id, $id, Request $request)
    {
        $this->question->update($request->only(
            $this->question->fillables()
        ), $id);

        $question = $this->question->find($id);

        $this->question->updateOptions($question, $request->get('options'));

        $this->question->updateFiles($question, $request->get('files'));

        return response()->json([
            "data"      =>  [] ,
            "message"   => $this->saved_message
        ], 200);
    }


    public function destroy($script_id, $id)
    {

        $this->authorize('delete', Question::class);

        return response()->json([
            "result" => $this->question->delete($id),
            "message" => "Success deleted",
            "success" => true
        ], 200);
    }
}
