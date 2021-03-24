<?php
namespace App\Repositories\User;

use App\Models\User;

class UserDataAccessEQRepository implements UserDataAccessRepositoryInterface
{
  public function getAll()
  {
    return User::all();
  }
}
