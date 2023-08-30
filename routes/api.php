<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\TodoController;

//Todo Controller

Route::GET('/', [TodoController::class, 'showTodo']);
Route::POST('/add-todo', [TodoController::class, 'createTodo']);
Route::PUT('/check-todo/{id}', [TodoController::class, 'checkTodo']);
Route::DELETE('/delete-todo/{id}', [TodoController::class, 'deleteTodo']);