<?php

namespace App\Http\Controllers;

use App\Models\Emails;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class Recuperar extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validacao = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validacao->fails()) :
            return redirect('admin/login')->withErrors($validacao)->withInput();
        else :

            $senha = uniqid();

            $user           = User::where('email', $request->email)->first();

            $user->password    = bcrypt($senha);

            $user->save();

            Emails::sendRecuperar($senha, $request->email);

            session()->flash('flash_message', 'Verifique seu e-mail!');

            return redirect('admin/login');

        endif;
    }
}
