<?php
declare(strict_types=1)

namespace App\Entities;

class BookList implements \IteratorAggregate
{
  private $bookList;

  public function __construct()
  {
    $this -> bookList = new \ArrayObject();
  }

  public function add(Book $book)
  {
    $this -> bookList[] = $book;
  }

  public function getIterator() : \ArrayIterator
  {
    return $this -> bookList -> getIterator();
  }
}
