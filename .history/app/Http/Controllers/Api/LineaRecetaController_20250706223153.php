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

class LineaRecetaController extends Controller
{
    public function index()
    {
        $lineas = LineaReceta::all();
        return response()->json($lineas);
    }

    public function show($id)
    {
        $linea = LineaReceta::find($id);
        if (!$linea) {
            return response()->json(['mensaje' => 'Línea de receta no encontrada'], 404);
        }
        return response()->json($linea);
    }

    public function store(Request $request)
    {
        $linea = LineaReceta::create($request->only(['receta_id', 'ingrediente', 'cantidad']));
        return response()->json(['mensaje' => 'Línea de receta creada', 'data' => $linea], 201);
    }

    public function update(Request $request, $id)
    {
        $linea = LineaReceta::find($id);
        if (!$linea) {
            return response()->json(['mensaje' => 'Línea de receta no encontrada'], 404);
        }
        $linea->update($request->only(['receta_id', 'ingrediente', 'cantidad']));
        return response()->json(['mensaje' => 'Línea de receta actualizada', 'data' => $linea]);
    }

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