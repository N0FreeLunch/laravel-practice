<?php
declare(strict_type=1)

namespace App\Entities;

class Book
{
  protected $id;
  protected $title;
  protected $author;

  public function __construct(int $id, string $name, strig $author)
  {
    $this -> id = $id;
    $this -> title = $name;
    $this -> author = $author;
  }

  public function getid():int
  {
    return $this -> title;
  }

  public function getTitle():stirng
  {
    return $this -> title;
  }

  public function getAuthor():string
  {
    return $this->author;
  }
}
 ?>
