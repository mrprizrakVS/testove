<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        return Projects::all();
    }

    public function show(Projects $Projects)
    {
        return $Projects;
    }

    public function store(Request $request){
        $Projects = Projects::create($request->all());
        return response()->json($Projects, 201);
    }

    public function update(Request $request, Projects $Projects){
        $Projects->update($request->all());
        return response()->json($Projects, 200);
    }

    public function delete(Projects $Projects){
        $Projects->delete();
        return response()->json(null, 204);
    }
}
