<?php
declare(strict_types=1);

use App\Services\BookDataAccess;
use App\Book as BookModel;
use App\Entities\Book;
use App\Entities\BookList;

class BookMysqlRepository implements BookDataAccesss
{
  protected $BookModel;
  protected $BookList;

  private $connection = 'mysql';

  public function __construct(BookModel $BookModel, BookList $BookList)
  {
    $this -> BookModel = $BookModel;
    $this -> BookList = $BookList;
  }

  public function getList():BookList
  {
    $data = $this->BookModel::on($this -> connection) -> with('author:id, name')->get();

    foreach ($data as $d) {
      $this -> BookList -> add(new Book($d->id, $d->name, $d -> author -> name));
    }

    return $this -> BookList;

  }
}

 ?>
