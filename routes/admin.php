<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use ServerGroups\Http\Controllers\AdminController;

Route::get('/groups', [AdminController::class, 'index']);
Route::post('/groups', [AdminController::class, 'store']);
Route::put('/groups/{id}', [AdminController::class, 'update'])->whereNumber('id');
Route::delete('/groups/{id}', [AdminController::class, 'destroy'])->whereNumber('id');
Route::post('/sync', [AdminController::class, 'sync']);
Route::get('/users', [AdminController::class, 'users']);
Route::get('/servers', [AdminController::class, 'servers']);
