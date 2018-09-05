<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ClientsController extends Controller
{
    public function index()
    {
        return Clients::all();
    }

    public function show(Clients $clients)
    {
        return $clients;
    }

    public function store(Request $request){
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required'
        ];
        $validation = Validator::make($request->all(), $rules);

        if($validation->fails()){
            return response()->json([], 422);
        }

        $clients = Clients::create($request->all());
        return response()->json($clients, 201);
    }

    public function update(Request $request, Clients $clients){
        $clients->update($request->all());
        return response()->json($clients, 200);
    }

    public function delete(Clients $clients){
        $clients->delete();
        return response()->json(null, 204);
    }
}
