<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientTodoController;
use Illuminate\Support\Facades\DB;


Route::GET('/', function () {
    return view('layout');
});


Route::GET('/', function () {
    $data_domain = DB::table('domains')->get();

    return view('index', [
        'data_domain' => $data_domain
    ]);
});

Route::GET('/history', function () {
    $data_domain = DB::table('history')->get();

    return view('history', [
        'data_domain' => $data_domain
    ]);
});

Route::POST('/import-txt', [ClientTodoController::class, 'importTxt']);
Route::POST('/add-domain', [ClientTodoController::class, 'createDomain']);
Route::DELETE('/delete-domain/{domain_name}', [ClientTodoController::class, 'deleteDomain']);

Route::DELETE('/delete-list-domain/{domain_name}', [ClientTodoController::class, 'deleteListDomain']);

Route::GET('/export-powerdns', [ClientTodoController::class, 'exportPowerDNS']);


