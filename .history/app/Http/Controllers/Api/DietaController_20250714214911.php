<?php

namespace App\Http\Controllers\Api;

use App\Models\Dieta;
use App\Models\Ingrediente;
use App\Models\Categoria;
use App\Models\Usuario;
use App\Models\Comentario;
use App\Models\Receta;
use App\Models\LineaReceta;
use App\Models\Inventario;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

class DietaController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Dietas",
     *     description="Operaciones sobre dietas"
     * )
     */
    public function index()
    {
        $dietas = Dieta::all();
        return response()->json($dietas);
    }

    /**
     * @OA\Get(
     *     path="/api/dietas/{id}",
     *     tags={"Dietas"},
     *     summary="Obtener una dieta por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Dieta encontrada"),
     *     @OA\Response(response=404, description="Dieta no encontrada")
     * )
     */
    public function show($id)
    {
        $dieta = Dieta::find($id);
        if (!$dieta) {
            return response()->json(['mensaje' => 'Dieta no encontrada'], 404);
        }
        return response()->json($dieta);
    }

    /**
     * @OA\Post(
     *     path="/api/dietas",
     *     tags={"Dietas"},
     *     summary="Crear una nueva dieta",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "categoria"},
     *             @OA\Property(property="nombre", type="string", example="Dieta Mediterránea"),
     *             @OA\Property(property="descripcion", type="string", example="Una dieta rica en frutas, verduras y aceite de oliva"),
     *             @OA\Property(property="categoria", type="string", example="Saludable")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Dieta creada exitosamente"),
     *     @OA\Response(response=400, description="Solicitud incorrecta")
     * )
     */
    public function store(Request $request)
    {
        $dieta = Dieta::create($request->only(['nombre', 'descripcion']));
        return response()->json(['mensaje' => 'Dieta creada', 'data' => $dieta], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/dietas/{id}",
     *     tags={"Dietas"},
     *     summary="Actualizar una dieta existente",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "descripcion", "categoria"},
     *             @OA\Property(property="nombre", type="string", example="Dieta Vegana"),
     *             @OA\Property(property="descripcion", type="string", example="Una dieta basada en plantas"),
     *             @OA\Property(property="categoria", type="string", example="Vegana")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Dieta actualizada exitosamente"),
     *     @OA\Response(response=404, description="Dieta no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $dieta = Dieta::find($id);
        if (!$dieta) {
            return response()->json(['mensaje' => 'Dieta no encontrada'], 404);
        }
        $dieta->update($request->only(['nombre', 'descripcion']));
        return response()->json(['mensaje' => 'Dieta actualizada', 'data' => $dieta]);
    }

    /**
     * @OA\Delete(
     *     path="/api/dietas/{id}",
     *     tags={"Dietas"},
     *     summary="Eliminar una dieta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Dieta eliminada exitosamente"),
     *     @OA\Response(response=404, description="Dieta no encontrada")
     * )
     */
    public function destroy($id)
    {
        $dieta = Dieta::find($id);
        if (!$dieta) {
            return response()->json(['mensaje' => 'Dieta no encontrada'], 404);
        }
        $dieta->delete();
        return response()->json(['mensaje' => 'Dieta eliminada']);
    }
}
