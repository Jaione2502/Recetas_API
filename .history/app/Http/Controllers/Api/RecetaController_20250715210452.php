<?php

namespace App\Http\Controllers\Api;

use App\Models\Receta;
use App\Models\Ingrediente;
use App\Models\Categoria;
use App\Models\Usuario;
use App\Models\Comentario;
use App\Models\Dieta;
use App\Models\LineaReceta;
use App\Models\Inventario;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use OA\Annotations as OA;

class RecetaController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Receta",
     *     description="Operaciones sobre las recetas"
     * )
     */
    public function index()
    {
        $recetas = Receta::all();
        return response()->json($recetas);
    }

    /**
     * @OA\Get(
     *     path="/api/recetas/{id}",
     *     tags={"Receta"},
     *     summary="Obtener una receta por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Receta encontrada"),
     *     @OA\Response(response=404, description="Receta no encontrada")
     * )
     */
    public function show($id)
    {
        $receta = Receta::find($id);

        if (!$receta) {
            return response()->json(['mensaje' => 'Receta no encontrada'], 404);
        }

        return response()->json($receta);
    }

    /**
     * @OA\Post(
     *     path="/api/recetas",
     *     tags={"Receta"},
     *     summary="Crear una nueva receta",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "categoria"},
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="categoria", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Receta creada"),
     *     @OA\Response(response=400, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $receta = Receta::create([
            'usuario_id' => Auth::id(),
            'categoria_id' => $request->input('categoria_id'),
            'titulo' => $request->input('titulo'),
            'descripcion' => $request->input('descripcion'),
            'instrucciones' => $request->input('instrucciones'),
            'tiempo_preparacion' => $request->input('tiempo_preparacion'),
            'porciones' => $request->input('porciones'),
        ])->with(['usuario', 'categoria', 'ingredientes', 'comentarios',
        ]);

        return response()->json(['mensaje' => 'Receta creada', 'data' => $receta], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/recetas/{id}",
     *     tags={"Receta"},
     *     summary="Actualizar una receta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "categoria"},
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string"),
     *             @OA\Property(property="categoria", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Receta actualizada"),
     *     @OA\Response(response=404, description="Receta no encontrada")
     * )
     */
    public function update(Request $request, $id)
{
    $receta = Receta::find($id);

    if (!$receta) {
        return response()->json(['mensaje' => 'Receta no encontrada'], 404);
    }


    $receta->update([
        'usuario_id' => Auth::id(),
        'categoria_id' => $request->input('categoria_id', $receta->categoria_id),
        'titulo' => $request->input('titulo', $receta->titulo),
        'descripcion' => $request->input('descripcion', $receta->descripcion),
        'instrucciones' => $request->input('instrucciones', $receta->instrucciones),
        'tiempo_preparacion' => $request->input('tiempo_preparacion', $receta->tiempo_preparacion),
        'porciones' => $request->input('porciones', $receta->porciones),
    ]);

    $receta->load(['usuario', 'categoria', 'ingredientes', 'comentarios']);

    return response()->json(['mensaje' => 'Receta actualizada', 'data' => $receta], 200);
}


    /**
     * @OA\Delete(
     *     path="/api/recetas/{id}",
     *     tags={"Receta"},
     *     summary="Eliminar una receta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Receta eliminada"),
     *     @OA\Response(response=404, description="Receta no encontrada")
     * )
     */
    public function destroy($id)
    {
        $receta = Receta::find($id);

        if (!$receta) {
            return response()->json(['mensaje' => 'Receta no encontrada'], 404);
        }

        $receta->delete();

        return response()->json(['mensaje' => 'Receta eliminada']);
    }
}
