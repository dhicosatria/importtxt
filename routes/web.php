<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientTodoController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Routing\Route as RoutingRoute;

Route::GET('/', function () {
    return view('layout');
});


Route::middleware('auth')->group(function () {
    Route::GET('/history', function () {
        $data_domain = DB::table('history')->get();
    
        return view('history', [
            'data_domain' => $data_domain
        ]);
    });
    Route::GET('/', function () {
        $data_domain = DB::table('domains')->get();
    
        return view('index', [
            'data_domain' => $data_domain
        ]);
    });    
});


Route::POST('/import-txt', [ClientTodoController::class, 'importTxt']);
Route::POST('/add-domain', [ClientTodoController::class, 'createDomain']);
Route::DELETE('/delete-domain/{domain_name}', [ClientTodoController::class, 'deleteDomain']);

Route::DELETE('/delete-list-domain/{domain_name}', [ClientTodoController::class, 'deleteListDomain']);

Route::GET('/export-powerdns', [ClientTodoController::class, 'exportPowerDNS']);
Route::PATCH('/patch-powerdns', [ClientTodoController::class, 'patchPowerDNS']);

Route::GET('/login', [LoginController::class, 'halamanlogin'])->name('login');
Route::GET('/reGisTPosT', [LoginController::class, 'registerPage']);
Route::POST('/processRegister', [LoginController::class, 'createUser']);
Route::POST('/postlogin', [LoginController::class, 'loginProcess']);
Route::GET('/logout', [LoginController::class, 'logout']);
