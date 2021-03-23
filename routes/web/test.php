<?php
use App\Http\Controllers\SampleController;
Route::get('/sample', [SampleController::class, 'index']);
