<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use Illuminate\Http\Request;
use OA\Annotations as OA;

class InventarioController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Inventario",
     *     description="Operaciones sobre el inventario"
     * )
     */
    public function index()
    {
        return Inventario::all();
    }

     /**
     * @OA\Post(
     *     path="/api/inventario",
     *     tags={"Inventario"},
     *     summary="Crear un nuevo inventario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="usuario_id", type="integer"),
     *             @OA\Property(property="ingrediente_id", type="integer"),
     *             @OA\Property(property="cantidad", type="number")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Inventario creado")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/inventario/{id}",
     *     tags={"Inventario"},
     *     summary="Obtener un inventario por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Inventario encontrado"),
     *     @OA\Response(response=404, description="Inventario no encontrado")
     * )    
     */
    public function show($id)
    {
        $inventario = Inventario::findOrFail($id);
        return response()->json($inventario, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/inventario/{id}",
     *     tags={"Inventario"},
     *     summary="Actualizar un inventario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *        @OA\JsonContent( required={"usuario_id", "ingrediente_id", "cantidad"},
     *      @OA\Property(property="usuario_id", type="integer"),
     *      @OA\Property(property="ingrediente_id", type="integer"),
     *      @OA\Property(property="cantidad", type="number", format="float")
     * )
     *     ),
     *     @OA\Response(response=200, description="Inventario actualizado"),
     *     @OA\Response(response=404, description="Inventario no encontrado")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/inventario/{id}",
     *     tags={"Inventario"},
     *     summary="Eliminar un inventario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Inventario eliminado exitosamente"),
     *     @OA\Response(response=404, description="Inventario no encontrado")
     * )
     */
    public function destroy($id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return response()->json(['mensaje' => 'Inventario eliminado']);
    }
}
