<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comentario;
use OpenApi\Annotations as OA;

class ComentarioController extends Controller
{
    /**
 * @OA\Tag(
 *     name="Comentarios",
 *     description="Operaciones sobre comentarios de recetas"
 * )
 */
    public function index()
    {
        
        $comentarios = Comentario::with(['usuario', 'receta'])->get();

        return response()->json($comentarios->map(function ($comentario) {
            return [
                'id' => $comentario->id,
                'contenido' => $comentario->contenido,
                'usuario' => $comentario->usuario->name ?? null,
                'receta' => $comentario->receta->titulo ?? null,
                
            ];
        }));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @OA\Post(
     *     path="/api/comentarios",
     *     tags={"Comentarios"},
     *     summary="Crear un nuevo comentario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id", "receta_id", "contenido"},
     *             @OA\Property(property="usuario_id", type="integer", example=1),
     *             @OA\Property(property="receta_id", type="integer", example=1),
     *             @OA\Property(property="contenido", type="string", example="Este es un comentario")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Comentario creado exitosamente"),
     *     @OA\Response(response=400, description="Solicitud incorrecta")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'receta_id' => 'required|exists:recetas,id',
            'contenido' => 'required|string',
        ]);

        $comentario = Comentario::create($request->all());

        return response()->json($comentario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @OA\Get(
     *     path="/api/comentarios/{id}",
     *     tags={"Comentarios"},
     *     summary="Obtener un comentario por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Comentario encontrado"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function show(string $id)
    {
          $comentario = Comentario::with(['usuario', 'receta'])
        ->findOrFail($id);

    return response()->json([
        'id' => $comentario->id,
        'contenido' => $comentario->contenido,
        'usuario' => $comentario->usuario->name ?? null,
        'receta' => $comentario->receta->titulo ?? null,
    ]);

        

    }

    /**
     * Update the specified resource in storage.
     *
     * @OA\Put(
     *     path="/api/comentarios/{id}",
     *     tags={"Comentarios"},
     *     summary="Actualizar un comentario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="contenido", type="string", example="Comentario actualizado")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Comentario actualizado exitosamente"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
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
     *
     * @OA\Delete(
     *     path="/api/comentarios/{id}",
     *     tags={"Comentarios"},
     *     summary="Eliminar un comentario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Comentario eliminado exitosamente"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function destroy(string $id)
    {
        $comentario  = Comentario::find($id);
        if(!$comentario) {
            return response()->json(['message' => 'Comentario no encontrado'],404);
        }

        $comentario ->delete();

        return response()->json(['message','Comentario borrado correctamente',200]);
    }
}
