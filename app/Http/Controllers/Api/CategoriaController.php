<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;



class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return Categoria::all();
   
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria  = Categoria::find($id);
        if(!$categoria) {
            return response()->json(['message' => 'Categoría no encontrada'],404);
        }

        $request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=> 'required|string|max:255',
        ]);

        $categoria -> update($request->all());
    }

    /**
     * Remove the specified resource from storage.
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
