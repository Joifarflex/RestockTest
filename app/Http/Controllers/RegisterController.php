<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Notifications\WelcomeEmailNotification;

class RegisterController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function actionregister(Request $request)
    {
        $username = User::get('username');
        $email = User::get('email');
        $getUsername = User::whereNotIn('username', $username)->get();
        $getEmail = User::whereNotIn('email', $email)->get();


        if($getUsername)
        {
            if(filter_var($getEmail, FILTER_VALIDATE_EMAIL))
            {
                Session::flash('message_failed', 'Register gagal. email tidak terdaftar.');  
            }  
            else
            {
                if(request()->hasfile('image')){
                    $imageName = time().'.'.request()->image->getClientOriginalExtension();
                    request()->image->move(public_path('storage'), $imageName);
                }

                $user = User::create([
                    'email' => $request->email,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'role' => 'USER',
                    'image' => $imageName ?? NULL,
                ]);

                $user->notify(new WelcomeEmailNotification($user));
                
                Session::flash('message_success', 'Register Berhasil. Akun Anda sudah Aktif silahkan Login menggunakan username dan password.');
            }
                
        }
        else
        {
            Session::flash('message_failed', 'Register gagal. username sudah digunakan sebelumnya.');  
        }
        
        return redirect('login');
    }
}
