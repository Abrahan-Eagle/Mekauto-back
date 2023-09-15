<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\profile;
use App\Models\Cell_Phone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Profiler\Profile as ProfilerProfile;

class AuthController extends Controller
{
    public function createUser(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|unique:users',
                'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
                'password' => 'required|string|min:8'
            ]);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
/*
            $user = profile::create([
                'name' => $request->name,
            ]);

            $user = Cell_Phone::create([
                'name' => $request->name,
            ]);
*/
            $token = $user->createToken('auth_token')->plainTextToken;

            $user_token = User::find($user->id);
            $user_token->update(['idToken' => $token]);
            /*
            return response()->json([
                'status' => true,
                'message' => 'Usuario creado con éxito'
            ], 200);
            */

            return redirect()->route('send-email-validation', [
                'fullname' => $request->name,
                'token_email' => $token,
                'status' => true,
                'message' => 'Usuario creado con éxito'
            ]);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function loginUser(Request $request)
    {
         try {

            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'El correo electrónico y la contraseña no coinciden con nuestro registro.',
                ], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'El usuario inició sesión correctamente',
                'data' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
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
            $fields = $request->validate([
                'email' => 'required|string|max:255',
                'idToken' => 'required|string',
            ]);

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
                    $token = $loginUser->createToken('auth_token')->plainTextToken;
                     return response()->json([
                        'status' => true,
                        'data' => $loginUser,
                        'message' => 'El usuario inició sesión correctamente',
                        'token' => $token,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Las credenciales de inicio de sesión no son válidas.'
                    ], 401);
                }
            } else {

                  $validator = Validator::make($request->all(), [
                    'familyName' => 'required|string|max:255',
                    'givenName' => 'required|string|max:255',
                    'email' => 'required|string|max:255|unique:users,email',
                    'imageUrl' => 'required|string|max:255',
                    'idToken' => 'required|string|max:255',
                ]);


                if ($validator->fails()) {
                    return response()->json($validator->errors());
                }
                // Si el usuario no existe, crearlo
                $fullname = $request->familyName . ' ' . $request->givenName;

                 $user = User::create([
                    'name' => $fullname,
                    'familyName' => $request->familyName,
                    'givenName' => $request->givenName,
                    'email' => $email,
                    'imageUrl' => $request->imageUrl,
                    'idToken' => $request->idToken,
                ]);

                //crea el token y almacena
                $token = $user->createToken('auth_token')->plainTextToken;

                 return response()->json([
                    'status' => true,
                    'message' => 'Usuario creado con éxito',
                    'token' => $token,
                    'token_type' => 'Bearer'
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
            'access_token' => 'required'
        ]);

        try {
            $user = Auth::user();
            $user->tokens()->where('tokenable_id', $user->id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'El usuario cerró sesión exitosamente'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Lo sentimos, el usuario no puede desconectarse.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getAuthUser(Request $request)
    {
        $request->validate([
            'access_token' => 'required'
        ]);

        $user = Auth::user();

        return response()->json(['user' => $user]);
    }

    public function update_Email_Activation ($token){

        try {

            $emailActivation = User::where('idToken', $token)->first();

            if ($emailActivation) {
                $emailActivation->email_verified = true;
                $emailActivation->email_verified_at = Carbon::now();
                $emailActivation->save();

                return response()->json([
                    'success' => true,
                    'message' => 'El usuario verifico email exitosamente'
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

}
