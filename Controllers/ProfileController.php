<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function getProfile()
    {
      return View::make('profile');
    }

    public function postCreate()
    {

    }
}
