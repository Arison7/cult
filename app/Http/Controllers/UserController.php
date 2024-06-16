<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required'
        ]);
    }
    public function uniqueUsername(Request $request){
        $name = $request->query('name');
        $output = $name && User::where('name', $name)->count() === 0;
        return response()->json([$output]);
    }
}