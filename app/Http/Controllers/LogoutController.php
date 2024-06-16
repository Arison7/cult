<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class LogOutController extends Controller
{
    public function store(){
        auth()->logout();
        return redirect()->route('auth.login');
    }
}