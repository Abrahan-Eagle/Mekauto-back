<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Requests\CreateRequest;
use App\Http\Requests\LoginRequest;



class AuthController extends Controller
{
    public function createUser(CreateRequest $request)
    {
        try {
            //Validated
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                        'status' => false,
                        'message' => 'El email ya esta registrado'
                    ], 401);
            }


            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $AccessToken = Str::random(80);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'AccessToken' => $AccessToken,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Usuario creado con éxito',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function loginUser(LoginRequest $request)
    {
         try {
            $validateUser = Validator::make(
                $request->all(),
                [
                'email' => 'required|email',
                'password' => 'required'
            ]
            );

            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'AccessToken' => $user -> AccessToken,
                //'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Create or Login User based on JSON data
     * @param Request $request
     * @return User
     */
    public function googleUser(Request $request)
    {
        try {
            // Obtener los datos del JSON recibido
            $jsonData = $request->json()->all();
            $email = $jsonData['email'];

            // Verificar si el usuario ya existe en la base de datos
            $existingUser = User::where('email', $email)->first();

            if ($existingUser) {
                // Si el usuario ya existe, iniciar sesión
                $loginUser = User::where('email', $email)
                    ->where('idToken', $request->idToken)
                    ->first();

                if ($loginUser) {
                    return response()->json([
                        'status' => true,
                        'message' => 'El usuario inició sesión correctamente',
                        'remember_token' => $loginUser -> remember_token,
                        /*'data' => [
                            'fullname' => $loginUser -> name,
                            'email' => $loginUser -> email,
                            'imageUrl' => $loginUser -> imageUrl
                            ]*/
                       // 'data' => $loginUser
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Las credenciales de inicio de sesión no son válidas.'
                    ], 401);
                }
            } else {
                // Si el usuario no existe, crearlo
                $remember_token = Str::random(80);
                $fullname = $request->familyName . ' ' . $request->givenName;

                $user = User::create([
                    'name' => $fullname,
                    'familyName' => $request->familyName,
                    'givenName' => $request->givenName,
                    'email' => $email,
                    'imageUrl' => $request->imageUrl,
                    'idToken' => $request->idToken,
                    'remember_token' => $remember_token,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Usuario creado con éxito',
                    'remember_token' => $user -> remember_token,
                    //'data' => $user,
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }



    public function logout(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        try {
            $user = Auth::user();
            $user->tokens()->where('tokenable_id', $user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthUser(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $user = Auth::user();

        return response()->json(['user' => $user]);
    }

}
