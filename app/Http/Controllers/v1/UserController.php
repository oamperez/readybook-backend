<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class UserController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $sortDesc = $request->input('sortDesc');
        $data = User::orderBy('id', $sortDesc)
        ->search($search)
        ->where('role', $request->input('role', 0))
        ->paginate($request->itemsPerPage);
        return response()->json($data, 200);
    }

    public function all(Request $request){
        $data = User::all();
        return response()->json($data, 200);
    }

    public function store(Request $request){
       $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'phone' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data = User::create($request->all());
        $data->password = bcrypt($request->password);
        $data->save();
        return response()->json([
            'message' => 'Registro creado con éxito.',
            'data' => $data
        ], 201);
    }

    public function show(Request $request, $id){
        $data = User::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $data = User::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,' . $data->id,
            'phone' => 'required',
        ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data->update($request->all());
        if($request->password){
            $data->password = bcrypt($request->password);
        }
        $data->save();
        return response()->json([
            'message' => 'Registro actualizado con éxito.',
            'data' => $data
        ], 200);
    }

    public function destroy(Request $request, $id){
        $data = User::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Registro eliminado con éxito.'
        ], 200);
    }
}
