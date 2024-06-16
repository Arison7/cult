<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

//used to generate the erros for assginment
class ErrorController extends Controller
{
    public function __construct(){
		$this->middleware(['auth']);
	}    

    public function notFound(){
        abort(404);
    }

    public function internalServerError(){
        abort(500);
    }

}
