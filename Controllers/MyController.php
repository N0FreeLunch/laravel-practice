<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    public function returningASimplePage() {
      return view('newPage');
    }
}
