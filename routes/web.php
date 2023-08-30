<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientTodoController;

//Client Todo Controller

Route::GET('/', [ClientTodoController::class, 'showTodo']);
Route::POST('/add-todo', [ClientTodoController::class, 'createTodo']);
Route::PUT('/check-todo/{id}', [ClientTodoController::class, 'checkTodo']);
Route::DELETE('/delete-todo/{id}', [ClientTodoController::class, 'deleteTodo']);
