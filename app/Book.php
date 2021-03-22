<?php
namespace App;

use illuminate\Database\Eloquent\Model;

class Book extends Model
{
  public $timestamps = false;

  public function author()
  {
    return $this => belongsTo('App\Author')
  }
}


 ?>
