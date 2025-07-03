<?php

use Illuminate\Support\Facades\Route;
use App\http\controllers\Api\CategoriaController;
use App\Http\Controllers\Api\IngredienteController;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\Api\MenuController;

Route::apiResource('categoria',CategoriaController::class);
Route::apiResource('inventario',InventarioController::class);
Route::apiResource('menus',MenuController::class);
Route::apiResource('ingredientes',IngredienteController::class);

