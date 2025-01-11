<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function __construct()
    {
        $methodName = \Illuminate\Support\Facades\Route::getCurrentRoute()->getActionMethod();

        $exceptActionArray = array('login','register','forgotPassword','resetPassword','refreshToken');
        if(!in_array($methodName,$exceptActionArray)){
            $this->tokenData();
        }
    }
    public function tokenData(){
        $this->user = auth()->user();
        #$this->test = 'This is test';
    }
}
