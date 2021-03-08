<?php
namespace Customer\Profiling;

use Illuminate\Http\Request;

class ProfileController
{
    public function getProfile()
    {
      return View::make('profile');
    }

    public function postCreate()
    {

    }
}
