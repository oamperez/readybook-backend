<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CountParticipantImport;
use Illuminate\Support\Facades\Storage;
use App\Imports\ParticipantImport;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Appointment;
use App\Jobs\ImportJob;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class AppointmentController extends Controller
{
    public function index(Request $request){
        $appointments = Appointment::all();
        $data = collect();
        foreach($appointments as $item){
            $data->push([
                'id' => $item->id,
                'state' =>  $item->state,
                'name' =>  '#'. $item->id . ' / ' .$item->user->first_name . ' ' . $item->user->last_name,
                'start' => Carbon::parse($item->date . ' ' . $item->schedule->start_time)->format('Y-m-d h:i'),
                'end' => Carbon::parse($item->date . ' ' . $item->schedule->end_time)->format('Y-m-d h:i')
            ]);
        }
        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'step' => 'required',
            'category_id' => $request->step == 1 ? 'required|exists:categories,id' : '',
            'date' => $request->step == 1 ? 'required' : '',
            'schedule_id' => $request->step == 2 ? 'required|exists:schedules,id' : '',
            // 'file' => $request->step == 3 ? 'required|max:5120' : '',
            'first_name' => $request->step == 4 ? 'required' : '',
            'last_name' => $request->step == 4 ? 'required' : '',
            'phone' => $request->step == 4 ? 'required' : '',
            'email' => $request->step == 4 ? 'required' : '',
            'detail' => $request->step == 4 ? 'required' : '',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        if($request->step == 5){
            $user = User::where('email', $request->email)->first();
            if(is_null($user)){
                $user = User::create($request->all());
                $user->save();
            }else{
                $user->update($request->all());
                $user->save();
            }
            $data = Appointment::create($request->all());
            $data->user_id = $user->id;
            $data->save();
            if($request->file('file')){
                $file = $request->file('file');
                $name = time().Str::random(5).'.'.$file->getClientOriginalExtension();
                $path = Storage::putFileAs('/', $request->file('file'), $name);
                ImportJob::dispatch($path, $data->id);
            }
            return response()->json([
                'message' => 'Cita generada con éxito.',
                'data' => $data
            ], 201);
        }
        return response()->json(['step' => intval($request->step) + 1], 200);
    }

    public function show(Request $request, $id){
        $data = Appointment::with('user', 'category', 'schedule', 'participants')->find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $data = Appointment::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $validator = Validator::make($request->all(), [
            'state' => 'required',
            'reason' => 'required_if:state,==,2',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $data->update($request->all());
        $data->save();
        return response()->json([
            'message' => 'Evento ' . ($request->state == 1 ? 'Aprobado' : 'Rechazado') . ' con éxito.',
            'data' => $data
        ], 200);
    }

    public function destroy(Request $request, $id){
        $data = Appointment::find($id);
        if(is_null($data)){
            return response()->json(['message' => 'No se encontró el registro.'], 404);
        }
        $data->delete();
        return response()->json([
            'message' => 'Registro eliminado con éxito.'
        ], 200);
    }

    public function participants(Request $request){
        $import = new CountParticipantImport;
        Excel::import($import, request()->file('file'));
        return response()->json($import->getRowCount(), 200);
    }
}
