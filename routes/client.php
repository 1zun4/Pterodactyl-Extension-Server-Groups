<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use ServerGroups\Http\Controllers\ClientController;

Route::get('/groups', [ClientController::class, 'index']);
