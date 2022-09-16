<?php

use App\Http\Controllers\Api\TendersController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tenders', TendersController::class);
