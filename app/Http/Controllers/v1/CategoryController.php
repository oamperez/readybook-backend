<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $sortDesc = $request->input('sortDesc');
        $data = Category::orderBy('id', $sortDesc)
        ->search($search)
        ->paginate($request->itemsPerPage);
        return response()->json($data, 200);
    }

    public function all(Request $request){
        $data = Category::all();
        return response()->json($data, 200);
    }

    public function get_users(Request $request, $id){
        $category = Category::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $users = User::all();
        $data = [
            'users' => $users,
            'category_users' => $category->users->pluck('id')
        ];
        return response()->json($data, 200);
    }

    public function add_users(Request $request, $id){
        $category = Category::find($id);
        if(is_null($category)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $category->users()->sync($request->users);
        return response()->json([
            'message' => 'Usuarios agregados con éxito.',
        ], 201);
    }

    public function store(Request $request){
       $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data = Category::create($request->all());
        $data->save();
        return response()->json([
            'message' => 'Registro creado con éxito.',
            'data' => $data
        ], 201);
    }

    public function show(Request $request, $id){
        $data = Category::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $data = Category::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
       $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data->update($request->all());
        $data->save();
        return response()->json([
            'message' => 'Registro actualizado con éxito.',
            'data' => $data
        ], 200);
    }

    public function destroy(Request $request, $id){
        $data = Category::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Registro eliminado con éxito.'
        ], 200);
    }
}
