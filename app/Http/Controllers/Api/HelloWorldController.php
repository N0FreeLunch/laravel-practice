<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelloWorldController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'hello world'
        ]);
    }
}
