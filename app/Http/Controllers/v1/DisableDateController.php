<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Appointment;
use App\Models\DisableDate;
use App\Models\AppSetting;
use Carbon\Carbon;
use Validator;
use DB;

class DisableDateController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $sortDesc = $request->input('sortDesc');
        $data = DisableDate::orderBy('id', $sortDesc)
        ->search($search)
        ->paginate($request->itemsPerPage);
        return response()->json($data, 200);
    }

    public function disabledates(Request $request){
        $data = DisableDate::select(DB::raw("date"))->pluck('date')->get();
        return response()->json($data, 200);
    }

    public function disabledallow(Request $request){
        $data = AppSetting::latest()->first();
        if(is_null($data)){
            $data = AppSetting::create($request->all());
        }
        return response()->json($data->non_days ?? [], 200);
    }

    public function disabledallowupdate(Request $request){
        $data = AppSetting::latest()->first();
        if(is_null($data)){
            $data = AppSetting::create($request->all());
        }else{
            $data->update($request->all());
        }
        $data->save();
        return response()->json([
            'message' => 'Configuración de de fechas inactivas agregada con éxito.',
            'data' => $data
        ], 200);
    }

    public function all(Request $request){
        $data = DisableDate::all();
        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'date' => 'required|unique:disable_dates,date',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data = DisableDate::create($request->all());
        $data->save();
        return response()->json([
            'message' => 'Registro creado con éxito.',
            'data' => $data
        ], 201);
    }

    public function show(Request $request, $id){
        $data = DisableDate::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $data = DisableDate::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'date' => 'required|unique:disable_dates,date,'. $data->id,
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
        $data = DisableDate::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Registro eliminado con éxito.'
        ], 200);
    }
}
