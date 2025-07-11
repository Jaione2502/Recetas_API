<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class IngredienteController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Ingredientes",
     *     description="Operaciones sobre ingredientes"
     * )
     */
    public function index()
    {
        return response()->json(Ingrediente::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/ingredientes",
     *     tags={"Ingredientes"},
     *     summary="Crear un nuevo ingrediente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "unidad_medida"},            
     *             @OA\Property(property="nombre", type="string", example="Sal"),
     *             @OA\Property(property="descripcion", type="string", example="Sal de la costa"),
     *             @OA\Property(property="unidad_medida", type="string", example="Kg")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Ingrediente creado exitosamente"),
     *     @OA\Response(response=400, description="Solicitud incorrecta")
     * )    
     */
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

    /**
     * @OA\Get(
     *     path="/api/ingredientes/{id}",
     *     tags={"Ingredientes"},
     *     summary="Obtener un ingrediente por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Ingrediente encontrado"),
     *     @OA\Response(response=404, description="Ingrediente no encontrado")
     * )
     */
    public function show($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        return response()->json($ingrediente, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/ingredientes/{id}",
     *     tags={"Ingredientes"},
     *     summary="Actualizar un ingrediente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "unidad_medida"},
     *             @OA\Property(property="nombre", type="string", example="Azúcar"),
     *             @OA\Property(property="descripcion", type="string", example="Azúcar moreno"),
     *             @OA\Property(property="unidad_medida", type="string", example="Gramos")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Ingrediente actualizado correctamente"),
     *     @OA\Response(response=404, description="Ingrediente no encontrado")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/ingredientes/{id}",
     *     tags={"Ingredientes"},
     *     summary="Eliminar un ingrediente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Ingrediente eliminado exitosamente"),
     *     @OA\Response(response=404, description="Ingrediente no encontrado")
     * )
     */
    public function destroy($id)
    {
        $ingrediente = Ingrediente::findOrFail($id);
        $ingrediente->delete();

        return response()->json(['mensaje' => 'Ingrediente eliminado']);
    }
}
