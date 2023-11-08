<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\MailSetting;
use App\Models\AppSetting;
use Carbon\Carbon;
use Validator;
use DB;

class SettingController extends Controller
{
    public function app(Request $request){
        $data = AppSetting::latest()->first();
        if(is_null($data)){
            $data = AppSetting::create($request->all());
        }
        return response()->json($data, 200);
    }

    public function setapp(Request $request){
        $data = AppSetting::latest()->first();
        if(is_null($data)){
            $data = AppSetting::create($request->all());
        }
        return response()->json($data, 200);
    }

    public function appupdate(Request $request){
        $data = AppSetting::latest()->first();
        $validator = Validator::make($request->all(), [
            'app_name' => 'required',
            'file' => 'max:5120',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        if(is_null($data)){
            $data = AppSetting::create($request->all());
        }else{
            $data->update($request->all());
        }
        if($request->file('file')){
            $file = $request->file('file');
            $name = time().Str::random(5).'.'.$file->getClientOriginalExtension();
            $path = Storage::putFileAs('/app', $request->file('file'), $name);
            $data->fill(['icon' => $path ]);
        }
        $data->save();
        return response()->json([
            'message' => 'Configuración de correo electrónico agregada con éxito.',
            'data' => $data
        ], 200);
    }

    public function mail(Request $request){
        $data = MailSetting::latest()->first();
        if(is_null($data)){
            $data = MailSetting::create($request->all());
        }
        return response()->json($data, 200);
    }

    public function mailupdate(Request $request){
        $data = MailSetting::latest()->first();
        $validator = Validator::make($request->all(), [
            'MAIL_MAILER' => 'required',
            'MAIL_HOST' => 'required',
            'MAIL_USERNAME' => 'required',
            'MAIL_PASSWORD' => 'required',
            'MAIL_ENCRYPTION' => 'required',
            'MAIL_FROM_ADDRESS' => 'required',
            'MAIL_FROM_NAME' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        if(is_null($data)){
            $data = MailSetting::create($request->all());
        }else{
            $data->update($request->all());
        }
        $data->save();
        return response()->json([
            'message' => 'Configuración de correo electrónico agregada con éxito.',
            'data' => $data
        ], 200);
    }
}
