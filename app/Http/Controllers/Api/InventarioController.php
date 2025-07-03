<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    // GET /api/inventario
    public function index()
    {
        return Inventario::all();
    }

    // POST /api/inventario
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'ingrediente_id' => 'required|exists:ingredientes,id',
            'cantidad' => 'required|numeric|min:0',
        ]);

        $inventario = Inventario::create($validated);

        return response()->json([
            'mensaje' => 'Inventario creado correctamente',
            'data' => $inventario
        ], 201);
    }

    // GET /api/inventario/{id}
    public function show($id)
    {
        $inventario = Inventario::findOrFail($id);
        return response()->json($inventario, 200);
    }

    // PUT /api/inventario/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'ingrediente_id' => 'required|exists:ingredientes,id',
            'cantidad' => 'required|numeric|min:0',
        ]);

        $inventario = Inventario::findOrFail($id);
        $inventario->update($validated);

        return response()->json([
            'mensaje' => 'Inventario actualizado correctamente',
            'data' => $inventario
        ], 200);
    }

    // DELETE /api/inventario/{id}
    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return response()->json(['mensaje' => 'Inventario eliminado'], 204);
    }
}
