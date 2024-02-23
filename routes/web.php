<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\Api\HelloWorldController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
  return view('welcome');
});

Route::get('/pdftest', [ReceiptController::class, 'index']);

Route::get('/text', function () {
  return "welcome";
});

Route::get('/blade', function () {
  return view('welcome');
});

Route::get('/echo', function () {
  echo "welcome";
});

Route::get('/html', function () {
  echo "<Html>
  <head><title>Laravel</title>
    <style>
      html, body {
        height : 100%;
      }
      body {
        margin : 0;
        padding : 0;
        width : 100%;
        display : table;
        font-weight : 100;
        font-size : 20px;
        font-family : 'Lato';
      }
      .container {
        text-align : center;
        display : table-cell;
        vertical-align : middle;
      }
      .content {
        test-align : center;
        display : inline-block;
      }
      .title {
        font-size : 110;
      }
    </style>
    <body>
      <div class='container'>
        <div class='content'>
          <div class='title'>Hello, Dear Reader</div>
          <div class='container'>
          How are you? I hope you would love this book!
          </div>
        </div>
      </div>
    </body>
  </html>";
});

Route::get('hello/{name}', function ($name) {
    echo "Hello ".$name;
});

Route::any('any', function () {
  return "Anything is possble if you try hard!";
}) -> name('any');

// dd(__DIR__);
$path = __DIR__."/web";
$files = File::allFiles($path,'/routes');
foreach ($files as $partial) {
  require_once $partial;
}

Route::get('newpage', [MyController::class, 'returningASimplePage']);

Route::get('profile', [\App\Http\Controllers\Customer\Profiling\ProfileController::class, 'getProfile']);

Route::resource('user', UserController::class)->only(['index', 'show']);

Route::get('get-user', [UserController::class, 'getUsers']);

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'home'], function () {
  Route::get('/',[HomeController::class, 'Showindex']);
  Route::get('/about',[HomeController::class,'About']);
  Route::get('/contact', [HomeController::class, 'showContact']);
});

Route::group(['prefix' => 'api'], function () {
    Route::get('/home',[HelloWorldController::class, 'index']);
});
