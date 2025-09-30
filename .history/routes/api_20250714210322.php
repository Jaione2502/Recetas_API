<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\ComentarioController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\IngredienteController;
use App\Http\Controllers\Api\InventarioController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\RecetaController;
use App\Http\Controllers\Api\LineaRecetaController;
use App\Http\Controllers\Api\DietaController;

// RUTAS PÚBLICAS
Route::post('/login', [UsuarioController::class, 'login']);
Route::get('/recetas', [RecetaController::class, 'index']);
Route::get('/recetas/{id}', [RecetaController::class, 'show']);
Route::get('/dietas', [DietaController::class, 'index']);
Route::get('/dietas/{id}', [DietaController::class, 'show']);

// RUTAS PRIVADAS
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categoria', CategoriaController::class);
    Route::apiResource('comentario', ComentarioController::class);
    Route::apiResource('usuario', UsuarioController::class);
    Route::apiResource('inventario', InventarioController::class);
    Route::apiResource('menus', MenuController::class);
    Route::apiResource('ingredientes', IngredienteController::class);
    Route::apiResource('recetas', RecetaController::class, ['except' => ['index', 'show']]);
    Route::apiResource('lineas', LineaRecetaController::class);
    Route::apiResource('dietas', DietaController::class, ['except' => ['index', 'show']]);
    Route::post('/logout', [UsuarioController::class, 'logout']);
});
