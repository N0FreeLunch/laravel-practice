<?php
namespace App\Providers;

use illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  public function register()
  {
    // $this -> app -> bind(\App\Service\BookDataAccess::class, function($app) {
    //   return new \App\Repositories\BookMysqlRepository(new \App\Book, new \App\Entities\BookList);
    // })
  }

  public function boot()
  {
  }
}
 ?>
