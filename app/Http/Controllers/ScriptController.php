<?php

namespace App\Http\Controllers;

use App\Models\Script;
use App\Repositories\Script\ScriptRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ScriptController extends Controller
{

    private $script;

    public function __construct(ScriptRepository $script)
    {
        $this->script = $script;
    }

    public function index()
    {
        $this->authorize('view', Script::class);
        return Inertia::render('Admin/Script/Index', [
            "data" => $this->script->all()
        ]);
    }

    public function create()
    {
        $this->authorize('create', Script::class);

        return Inertia::render('Admin/Script/Create');
    }


    public function store(Request $request)
    {
        $this->authorize('create', Script::class);

        $this->script->create($request->only(
            $this->script->fillables()
        ));

        return redirect()->route('script.index')->with('success', $this->saved_message);
    }

    public function show($id)
    {

    }


    public function edit($id)
    {
        $this->authorize('edit', Script::class);

        return Inertia::render('Admin/Script/Edit', [
            "script" => $this->script->find($id)
        ]);

    }


    public function update(Request $request, $id)
    {
        $this->authorize('edit', Script::class);

        $this->script->update($request->only(
            $this->script->fillables()
        ), $id);

        return redirect()->route('script.index')->with('success', $this->saved_message);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Script::class);

        return response()->json([
            "result" => $this->script->delete($id),
            "message" => "Success deleted",
            "success" => true
        ], 200);
    }
}
