<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentario;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Comentario::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario_id',
            'receta_id' => 'required|exists:receta_id',
            'contenido' => 'required|string',
        ]);

        $comentario = Comentario::create($request->all());

        return response()->json($comentario, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         return Comentario::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comentario = Comentario::findOrFail($id);

        $request->validate([
            'contenido' => 'sometimes|required|string',
        ]);

        $comentario->update($request->all());

        return response()->json($comentario, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Comentario::destroy($id);

        return response()->json(['mensaje' => 'Comentario eliminado correctamente'], 204);
    }
}
