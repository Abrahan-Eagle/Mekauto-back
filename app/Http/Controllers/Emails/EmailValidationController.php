<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Mail\EmailValidation;



class EmailValidationController extends Controller
{
    public function index(Request $request){
       // return response()->json($request);

       if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        // La solicitud se realiza a través de HTTPS
        $url = "https://mekautos.uniblockweb.com/api/email-activation/";
        //echo "La solicitud se realiza a través de HTTPS";
        } else {
        // La solicitud se realiza a través de HTTP
        $url = "http://127.0.0.1:8000/api/email-activation/";
        }


        $mailData = [
            'status' => true,
            'fullname' => $request -> fullname,
            'urlWeb' => 'https://e-mekautos.com',
            'url' => $url,
            'token' => $request -> token_email,
        ];

        //$emails = ['auth.mekautos@uniblockweb.com', 'thehackeroffire@gmail.com', 'rennyfurnerimi@gmail.com', 'rennyfurneri@gmail.com' , 'davidostos2@gmail.com'];
        //$emails2 = ['auth.mekautos@uniblockweb.com', 'thehackeroffire@gmail.com'];

        Mail::to($request->email)->send(new EmailValidation($mailData));

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado con éxito'
        ], 200);
    }
}
