<?php

namespace App\Http\Controllers;
use App\Models\User;

interface AllUsers {
  public function getUsers();
}

class GetAllUsers implements AllUsers
{
    public function getUsers() {
      $users = User::all();
      return $users;
    }
}
