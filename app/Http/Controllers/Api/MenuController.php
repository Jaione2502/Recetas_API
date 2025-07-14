<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use OA\Annotations as OA;

class MenuController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Menu",
     *     description="Operaciones sobre los menús"
     * )
     */
    public function index()
    {
        return response()->json(Menu::all(), 200);
    }

    /**
 * @OA\Post(
 *     path="/api/menus",
 *     tags={"Menu"},
 *     summary="Crear un menú",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"usuario_id", "nombre", "fecha"},
 *             @OA\Property(property="usuario_id", type="integer"),
 *             @OA\Property(property="nombre", type="string"),
 *             @OA\Property(property="fecha", type="string", format="date")
 *         )
 *     ),
 *     @OA\Response(response=201, description="Menú creado correctamente")
 * )
 */
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

    /**
     * @OA\Get(
     *     path="/api/menus/{id}",
     *     tags={"Menu"},
     *     summary="Obtener un menú por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Menú encontrado"),
     *     @OA\Response(response=404, description="Menú no encontrado")
     * )
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/menus/{id}",
     *     tags={"Menu"},
     *     summary="Actualizar un menú",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id", "fecha"},
     *             @OA\Property(property="usuario_id", type="integer"),
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="fecha", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Menú actualizado"),
     *     @OA\Response(response=404, description="Menú no encontrado")
     * )
     */   
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

    /**
     * @OA\Delete(
     *     path="/api/menus/{id}",
     *     tags={"Menu"},
     *     summary="Eliminar un menú",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Menú eliminado exitosamente"),
     *     @OA\Response(response=404, description="Menú no encontrado")
     * )
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return response()->json(['mensaje' => 'Menú eliminado']);
    }
}
