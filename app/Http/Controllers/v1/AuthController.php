<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request){
       $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
        $authorized = User::where('email', $request->email)->first();
        if($authorized){
            if(is_null($authorized->email_verified_at)){
                return response()->json(['message' => 'Tu correo electrónico aun no ha sido verificado.'], 404);
            }
            $password = \Hash::check($request->password, $authorized->password);
            if($password){
                $remember = $request->remember ? true : false;
                $token_result = $authorized->createToken('Personal Access Token');
                $auth = $token_result->token;
                if ($remember){
                    $auth->expires_at = Carbon::now()->addWeeks(1);
                }
                $auth->save();
                return response()->json([
                    'access_token' => $token_result->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => $auth->expires_at,
                    'user' => $authorized,
                ], 200);
            }else{
                return response()->json(['password'=>['La contraseña ingresada no es valida.']], 422);
            }
        }else{
            return response()->json(['email'=>['Correo electrónico y/o contraseña inválidos.']], 422);
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['message' => 'La sesión fue cerrada con éxito.'], 200);
    }

    public function me(Request $request){
        return response()->json($request->user(), 200);
    }
}
