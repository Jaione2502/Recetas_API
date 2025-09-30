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
use OA\Annotations as OA;

class LineaRecetaController extends Controller
{
    /**
     * @OA\Tag(
     *     name="LineaReceta",
     *     description="Operaciones sobre las líneas de receta"
     * )
     */
    public function index()
    {
        $lineas = LineaReceta::all();
        return response()->json($lineas);
    }

    /**
     * @OA\Get(
     *     path="/api/lineas-receta/{id}",
     *     tags={"LineaReceta"},
     *     summary="Obtener una línea de receta por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Línea de receta encontrada"),
     *     @OA\Response(response=404, description="Línea de receta no encontrada")
     * )
     */
    public function show($id)
    {
        $linea = LineaReceta::find($id);
        if (!$linea) {
            return response()->json(['mensaje' => 'Línea de receta no encontrada'], 404);
        }
        return response()->json($linea);
    }

    /**
     * @OA\Post(
     *     path="/api/lineas-receta",
     *     tags={"LineaReceta"},
     *     summary="Crear una nueva línea de receta",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"receta_id", "ingrediente", "cantidad"},
     *             @OA\Property(property="receta_id", type="integer"),
     *             @OA\Property(property="ingrediente", type="string"),
     *             @OA\Property(property="cantidad", type="number")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Línea de receta creada"),
     *     @OA\Response(response=400, description="Datos inválidos")
     * )
     */
    public function store(Request $request)
    {
        $linea = LineaReceta::create($request->only(['receta_id', 'ingrediente_id', 'paso', 'contenido', 'cantidad']));
        return response()->json(['mensaje' => 'Línea de receta creada', 'data' => $linea], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/lineas-receta/{id}",
     *     tags={"LineaReceta"},
     *     summary="Actualizar una línea de receta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"receta_id", "ingrediente", "cantidad"},
     *             @OA\Property(property="receta_id", type="integer"),
     *             @OA\Property(property="ingrediente", type="string"),
     *             @OA\Property(property="cantidad", type="number")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Línea de receta actualizada"),
     *     @OA\Response(response=404, description="Línea de receta no encontrada")
     * )
     */
    public function update(Request $request, $id)
    {
        $linea = LineaReceta::find($id);
        if (!$linea) {
            return response()->json(['mensaje' => 'Línea de receta no encontrada'], 404);
        }
        $linea->update($request->only(['receta_id', 'ingrediente_id', 'cantidad']));
        return response()->json(['mensaje' => 'Línea de receta actualizada', 'data' => $linea]);
    }

    /**
     * @OA\Delete(
     *     path="/api/lineas-receta/{id}",
     *     tags={"LineaReceta"},
     *     summary="Eliminar una línea de receta",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Línea de receta eliminada"),
     *     @OA\Response(response=404, description="Línea de receta no encontrada")
     * )
     */
    public function destroy($id)
    {
        $linea = LineaReceta::find($id);
        if (!$linea) {
            return response()->json(['mensaje' => 'Línea de receta no encontrada'], 404);
        }
        $linea->delete();
        return response()->json(['mensaje' => 'Línea de receta eliminada']);
    }
}
