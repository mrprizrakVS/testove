<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'statuses' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);

        if($validation->fails()){
            return response()->json([], 422);
        }

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
