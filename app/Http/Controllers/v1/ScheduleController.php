<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\DisableDate;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Country;
use Carbon\Carbon;
use Validator;
use DB;

class ScheduleController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $sortDesc = $request->input('sortDesc');
        $data = Schedule::orderBy('id', $sortDesc)
        ->search($search)
        ->paginate($request->itemsPerPage);
        return response()->json($data, 200);
    }

    public function calendar(Request $request){
        $dates = Appointment::select(DB::raw("date"))->groupBy('date')->get();
        $data = collect();
        foreach($dates as $date){
            $schedules = Appointment::where('date', $date->date)->get()->pluck('schedule_id')->toArray();
            $count = Schedule::whereNotIn('id', $schedules)->count();
            if($count == 0){
                $data->push($date->date);
            }
        }
        $disables = DisableDate::all();
        foreach($disables as $item){
            $data->push($item->date);
        }
        return response()->json($data, 200);
    }

    public function all(Request $request){
        $appointments = Appointment::where('date', $request->date)->get()->pluck('schedule_id')->toArray();
        $data = Schedule::all();
        return response()->json([
            'times' => $data,
            'notimes' => $appointments
        ], 200);
    }

    public function store(Request $request){
       $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data = Schedule::create($request->all());
        $data->save();
        return response()->json([
            'message' => 'Registro creado con éxito.',
            'data' => $data
        ], 201);
    }

    public function show(Request $request, $id){
        $data = Schedule::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $data = Schedule::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
       $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
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
        $data = Schedule::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Registro eliminado con éxito.'
        ], 200);
    }
    
    public function countries(Request $request){
        $countries = Country::all();
        return response()->json($countries, 200);
    }
}
