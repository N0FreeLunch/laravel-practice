<?php

namespace App\Http\Controllers\Customer\Profiling;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
  public function getProfile()
  {
    return \View::make('profile');
  }

  public function postCreate()
  {

  }
}
