<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;

class LoginController extends Controller
{
    public function halamanlogin()
    {
        return view('login');
    }

    public function registerPage()
    {
        return view('register');
    }

    public function loginProcess(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($data)) {
            $user = Auth::user();

            return redirect('/');
        } else {
            Session::flash('message', 'Username or Password Incorrect!'); 
            Session::flash('alert-class', 'alert-danger'); 
            return redirect('/login');
        }
    }
    
    public function createUser(Request $request)
    {
        $admin = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/logout');
    }
}
