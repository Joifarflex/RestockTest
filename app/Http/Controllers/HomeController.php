<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('home', compact('user'));
    }
}
