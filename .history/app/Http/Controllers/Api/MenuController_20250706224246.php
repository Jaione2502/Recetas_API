<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // GET /api/menus
    public function index()
    {
        return response()->json(Menu::all(), 200);
    }

    // POST /api/menus
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
        ]);

        $menu = Menu::create($validated);

        return response()->json([
            'mensaje' => 'Menú creado correctamente',
            'data' => $menu
        ], 201);
    }

    // GET /api/menus/{id}
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu, 200);
    }

    // PUT /api/menus/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'nombre' => 'nullable|string',
            'fecha' => 'required|date',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($validated);

        return response()->json([
            'mensaje' => 'Menú actualizado correctamente',
            'data' => $menu
        ], 200);
    }

    // DELETE /api/menus/{id}
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json(['mensaje' => 'Menú eliminado']);
    }
}
