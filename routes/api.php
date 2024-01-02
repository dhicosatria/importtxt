<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TodoController;

Route::POST('/import-txt', [TodoController::class, 'importTxt']);