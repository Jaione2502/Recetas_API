<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(title="API de Recetas", version="1.0")
 * @OA\Tag(name="Categorias", description="Operaciones relacionadas con las categorías")
 */
class CategoriaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/categorias",
     *     tags={"Categorias"},
     *     summary="Ver todas las categorías",
     *     @OA\Response(response=200, description="Listado de categorías")
     * )
     */
    public function index()
    {
         return Categoria::all();
   
    }

    /**
     * @OA\Post(
     *     path="/api/categorias",
     *     tags={"Categorias"},
     *     summary="Crear una nueva categoría",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Categoría creada")
     * )
     */
    public function store(Request $request)
    {
          $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=> 'required|string|max:255',
           
        ]);
        
        $categoria = Categoria::create($request->all());

        return response()->json(['id' => $categoria->id],201);
    }

    /**
     * @OA\Get(
     *     path="/api/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Ver una categoría específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la categoría",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Categoría encontrada"),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
    public function show(string $id)
    {
        
        $categoria = Categoria::select('nombre', 'descripcion')->find($id);

        if(!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'],404);
        }
        return  response()->json($categoria,200);



        
    }

    /**
     * @OA\Put(
     *     path="/api/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Actualizar una categoría",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la categoría",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="descripcion", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Categoría actualizada"),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
public function update(Request $request, string $id)
{
    $categoria  = Categoria::find($id);

    if (!$categoria) {
        return response()->json(['message' => 'Categoría no encontrada'], 404);
    }

    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string|max:255',
    ]);

    $categoria->update($request->all());

    return response()->json([
        'message' => 'Categoría actualizada correctamente',
        'categoria' => $categoria
    ], 200);

}

    /**
     * @OA\Delete(
     *     path="/api/categorias/{id}",
     *     tags={"Categorias"},
     *     summary="Eliminar una categoría",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la categoría",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Categoría eliminada"),
     *     @OA\Response(response=404, description="Categoría no encontrada")
     * )
     */
    public function destroy(string $id)
    {
        $categoria  = Categoria::find($id);
        if(!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'],404);
        }

        $categoria ->delete();

        return response()->json(['message','Categoría borrada correctamente',200]);
    }
}
