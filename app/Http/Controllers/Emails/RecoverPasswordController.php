<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Mail\RecoverPassword;



class RecoverPasswordController extends Controller
{
    public function index(Request $request){

        $email = 'ing.pulido.abrahan@gmail.com';

        $mailData = [
            'title' => 'Titulo',
            'url' => 'https://'
        ];

        Mail::to($email)->send(new RecoverPassword($mailData));


    }
}
