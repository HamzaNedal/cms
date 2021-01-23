<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }


    public function details()
    {
        return response()->json(auth()->user(),200);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['error'=>false,'message'=>'Successfully logged out'],200);
    }
}
