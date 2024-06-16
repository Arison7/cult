<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller{
    use AuthenticatesUsers;

    public function __construct(){
        $this->middleware(['guest']);
        $this->middleware('throttle:1,1');
    }
    public function index(){
        return view('auth.login');
    }
    public function store(Request $request){

		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
		$remember_me = $request->has('remember_me') ? true : false; 	

        if(!auth()->attempt($request->only('email','password'),$request->remember,$remember_me)){
            return back()->with('error', 'Invalid login details');
        }

        return redirect()->route('dashboard');
    }
    protected function maxAttempts()
    {
        return 1; // Maximum number of attempts to allow
    }

    protected function decayMinutes()
    {
        return 1; // Lockout time in minutes
    }

}