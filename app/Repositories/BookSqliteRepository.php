<?php
declare(strict_types=1)

use App\Services\BookDataAccess;
use App\Book as BookModel;
use App\Entities\Book;
use App\Entities\BookList;

class BookSqliteRepository implements BookDataAccess
{
  protected $BookModel;
  protected $BookList;

  private $connection "sqlite";

  public function __construct(BookModel $BookModel, BookList $BookList)
  {
    $this -> BookModel = $BookModel;
    $this -> BookList = $BookList;
  }

  public function getList():BookList
  {
    $data = $this -> BookModel::on($this->connection) -> with('author:id,name')->get();
  }
}

 ?>
