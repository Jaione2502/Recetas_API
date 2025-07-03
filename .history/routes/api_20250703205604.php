<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\controllers\Api\CategoriaController;
use App\Http\Controllers\Api\IngredienteController;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\Api\MenuController;

Route::apiResource('categoria',CategoriaController::class);
Route::apiResource('categoria',InventarioController::class);
Route::apiResource('categoria',MenuController::class);
Route::apiResource('categoria',IngredienteController::class);

