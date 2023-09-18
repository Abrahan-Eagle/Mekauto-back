<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Mail;
use App\Mail\RecoverPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RecoverPasswordController extends Controller
{
    public function index(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|max:255|unique:users'
            ]);

            if($validator->fails()){
                $user = User::where('email', $request->email)->firstOrFail();


                if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                    // La solicitud se realiza a través de HTTPS
                    $url = "https://mekautos.uniblockweb.com/api/recover-password-edit/" . $user->id;
                    //echo "La solicitud se realiza a través de HTTPS";
                    } else {
                    // La solicitud se realiza a través de HTTP
                    $url = "http://127.0.0.1:8000/api/recover-password-edit/" . $user->id;
                }

            $mailData = [
                'fullname' => $user->name,
                'url' => $url
            ];

            Mail::to($request->email)->send(new RecoverPassword($mailData));

            return response()->json([
                'status' => true,
                'message' => 'solicitud fue enviada con éxito'
            ], 200);

            }else {

                return response()->json([
                    'status' => false,
                    'message' => 'usuario no existe'
                ], 401);

            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }




    public function edit($token){

        try {

            $editPassword = User::where('id', $token)->first();

            if ($editPassword) {

            return response()->json([
                'success' => true,
                'message' => 'El usuario verifico email exitosamente',
                'token' =>  $editPassword->password
            ]);

            } else {
                // El token no se encontró en la base de datos
                return response()->json(['message' => 'Token no encontrado'], 404);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }













    public function update(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'token' => 'required|string|max:255',
                'password' => 'required|string|min:8'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }

            $updatePassword = User::where('password', $request->token)->first();

            if ($updatePassword) {
                $updatePassword->password = Hash::make($request->password);
                $updatePassword->save();

                return response()->json([
                    'success' => true,
                    'message' => 'El password fue actualizado exitosamente'
                ]);
            } else {
                // El token no se encontró en la base de datos
                return response()->json([
                    'status' => false,
                    'message' => 'usuario no encontrado'
                ], 404);
            }


























            return response()->json($request);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }



}
