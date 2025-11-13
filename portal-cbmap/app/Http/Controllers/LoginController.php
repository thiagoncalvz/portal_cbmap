<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class LoginController{
//     public function index(){
//         return view('login.index');
//     }

//     public function store(Request $request){
//         if(Auth::attempt($request->only(['cpf', 'password']))){
//             return redirect()->back()->withErrors(['Usuário ou senha inválidos']);
//         }
        
//         return to_route('regulamentos.index');
//     }
// }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function index()
    {
        return view('login.index');
    }

    // public function store(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'cpf'      => ['required','string'],
    //         'password' => ['required','string'],
    //     ]);

    //     if (Auth::attempt(['cpf' => $credentials['cpf'], 'password' => $credentials['password']], true)) {
    //         $request->session()->regenerate();
    //         return redirect()->intended('/regulamentos');
    //     }

    //     return back()
    //         ->withErrors(['cpf' => 'CPF ou senha inválidos'])
    //         ->onlyInput('cpf');
    // }

    public function store(Request $request)
    {
        $cred = $request->validate([
            'cpf' => ['required','string'],
            'password' => ['required','string'],
        ]);

        // limpar CPF
        $uid = preg_replace('/\D+/', '', $cred['cpf']);

        if (Auth::guard('web')->attempt(['uid' => $uid, 'password' => $cred['password']], true)) {
            $request->session()->regenerate();
            return redirect()->intended('/regulamentos');
        }

        return back()->withErrors(['cpf' => 'CPF ou senha inválidos'])->onlyInput('cpf');
    }

}
