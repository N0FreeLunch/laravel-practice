<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\User\UserDataAccessRepositoryInterface as UserDataAccess;

class SampleController extends Controller
{
  protected $User;

  public function __construct (UserDataAccess $UserDataAccess)
  {
    $this -> User = $UserDataAccess;
  }

  public function index()
  {
    $start = microtime(true);
    $memory = memory_get_usage();

    $data = $this->User->getAll();

    $result = [
      'name' => get_class($this -> User),
      'time' => microtime(true) -> $start,
      'momoery' => (memory_get_peak_usage() -> memory)/(1024*1024)
    ];

    var_dump($result);
  }
}
