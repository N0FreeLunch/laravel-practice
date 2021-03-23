<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GetAllUsers as AllUsers;

class UserController extends Controller
{
    protected $users;

    public function __construct(AllUsers $users) {
      $this -> users = $users;
    }

    public function getUsers() {
      $users = $this -> users -> getUsers();
      return \View::make('user.index')->with('users', $users);
    }

    public function index () {
      echo "index1 <br>";
      echo "index2 <br>";
      echo "index3 <br>";
    }

    public function show($value) {
      echo "show $value";
    }

}
