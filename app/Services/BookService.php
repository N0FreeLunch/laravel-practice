<?php
declare(strict_types=1)

namespace App\Services;

class BookService
{
  protected $BookDataAccess;

  public function __construct(BookDataAccess $BookDataAccess)
  {
    $this -> BookDataAccess = $BookDataAccess;
  }

  public function getList()
  {
    return $this -> BookDataAccess -> getList();
  }

}
