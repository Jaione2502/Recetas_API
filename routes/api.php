<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\controllers\Api\CategoriaController;

Route::apiResource('categoria',CategoriaController::class);