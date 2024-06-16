<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Psy\Readline\Hoa\Console;

class RegisterController extends Controller{
	public function __construct()
	{
		$this->middleware(['guest']);
	}

    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        //write more specifc error messages 
        

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'passwordConfirmation' => 'required|same:password'
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken. Please choose another name.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'passwordConfirmation.required' => 'The password confirmation field is required.',
            'passwordConfirmation.same' => 'The password confirmation does not match the password.'
        ]);
        //adds custom validation rules for each of the regex fields 
        $validator->after(function ($validator) use ($request) {
            $password = $request->input('password');

            if (!preg_match('/[a-z]/', $password)) {
                $validator->errors()->add('password', 'The password must contain at least one lowercase letter.');
            }
            if (!preg_match('/[A-Z]/', $password)) {
                $validator->errors()->add('password', 'The password must contain at least one uppercase letter.');
            }
            if (!preg_match('/[0-9]/', $password)) {
                $validator->errors()->add('password', 'The password must contain at least one number.');
            }
            if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
                $validator->errors()->add('password', 'The password must contain at least one special character.');
            }
        });
        //Since a custom validator is used the chekc has to be done manually
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
		auth()->attempt($request->only('email', 'password'));
		return redirect()->route('dashboard');
    }
}