<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function loginSubmit(Request $request)
    {
       $request->validate(
        [
                    'text_username' => 'required | email',
                    'text_password' => 'required| min:6|max:16'
        ],
        //messages
        [
            'text_username.required' => 'O username é obrigatorio',
            'text_username.email' => 'O username deve ser um email valido',
            'text_password.required' => 'a password é obrigatoria',
            'text_password.min' => 'a password deve ter no minimo 6 caracteres',
            'text_password.max' => 'a password deve ter no maximo 16 caracteres',


        ]
       );

       //get user input

       $username = $request->input('text_username');
       $password = $request->input('text_password');

       //check if user  exists
       $user = User::where('username', $username)
                        ->where('deleted_at', NULL)
                        ->first();

        if(!$user){
            return
            redirect()//refireciona
            ->back()  //manda pra tras
            ->withInput() //guarda no input
            ->with('loginError', 'username ou password incorretos');
        }

        //check if password is correct
        if(!password_verify($password, $user->password)){
            return
            redirect()//refireciona
            ->back()  //manda pra tras
            ->withInput() //guarda no input
            ->with('loginError', 'username ou password incorretos');
        }

        //update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        //login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

       //redirect to home
       return redirect()->to('/');

}
    public function logout()
    {
        //logout from the application
        session()->forget('user');
        return redirect()->to('/login');

        echo "LOGOUT COM SUCESSO!";
    }
}
