<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;

class IngredienteController extends Controller
{
    // GET /api/ingredientes
    public function index()
    {
        return response()->json(Ingrediente::all(), 200);
    }

    // POST /api/ingredientes
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:255',
        ]);

        $ingrediente = Ingrediente::create($validated);

        return response()->json([
            'mensaje' => 'Ingrediente creado correctamente',
            'data' => $ingrediente
        ], 201);
    }

    // GET /api/ingredientes/{id}
    public function show($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        return response()->json($ingrediente, 200);
    }

    // PUT /api/ingredientes/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:255',
        ]);

        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->update($validated);

        return response()->json([
            'mensaje' => 'Ingrediente actualizado correctamente',
            'data' => $ingrediente
        ], 200);
    }

    // DELETE /api/ingredientes/{id}
    public function destroy($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->delete();

        return response()->json(['mensaje' => 'Ingrediente eliminado'], 204);
    }
}
