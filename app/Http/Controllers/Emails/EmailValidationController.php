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


        $mailData = [
            'fullname' => $request -> fullname,
            'urlWeb' => 'https://e-mekautos.com',
            'token' => $request -> token_email,
        ];

        //$emails = ['auth.mekautos@uniblockweb.com', 'thehackeroffire@gmail.com', 'rennyfurnerimi@gmail.com', 'rennyfurneri@gmail.com' , 'davidostos2@gmail.com'];
        $emails2 = ['auth.mekautos@uniblockweb.com', 'thehackeroffire@gmail.com'];

        Mail::to($emails2)->send(new EmailValidation($mailData));

        return response()->json([
            'status' => true,
            'message' => 'Usuario creado con éxito'
        ], 200);



    }
}
