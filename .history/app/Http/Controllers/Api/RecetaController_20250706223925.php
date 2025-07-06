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

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::all();
        return response()->json($recetas);
    }

    public function show($id)
    {
        $receta = Receta::find($id);

        if (!$receta) {
            return response()->json(['mensaje' => 'Receta no encontrada'], 404);
        }

        return response()->json($receta);
    }

    public function store(Request $request)
    {
        $receta = Receta::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'categoria' => $request->input('categoria'),
        ]);

        return response()->json(['mensaje' => 'Receta creada', 'data' => $receta], 201);
    }

    public function update(Request $request, $id)
    {
        $receta = Receta::find($id);

        if (!$receta) {
            return response()->json(['mensaje' => 'Receta no encontrada'], 404);
        }

        $receta->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'categoria' => $request->input('categoria'),
        ]);

        return response()->json(['mensaje' => 'Receta actualizada', 'data' => $receta]);
    }

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
