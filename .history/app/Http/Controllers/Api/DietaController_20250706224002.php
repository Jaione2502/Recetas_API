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

class DietaController extends Controller
{
    public function index()
    {
        $dietas = Dieta::all();
        return response()->json($dietas);
    }

    public function show($id)
    {
        $dieta = Dieta::find($id);
        if (!$dieta) {
            return response()->json(['mensaje' => 'Dieta no encontrada'], 404);
        }
        return response()->json($dieta);
    }

    public function store(Request $request)
    {
        $dieta = Dieta::create($request->only(['nombre', 'descripcion', 'categoria']));
        return response()->json(['mensaje' => 'Dieta creada', 'data' => $dieta], 201);
    }

    public function update(Request $request, $id)
    {
        $dieta = Dieta::find($id);
        if (!$dieta) {
            return response()->json(['mensaje' => 'Dieta no encontrada'], 404);
        }
        $dieta->update($request->only(['nombre', 'descripcion', 'categoria']));
        return response()->json(['mensaje' => 'Dieta actualizada', 'data' => $dieta]);
    }

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
