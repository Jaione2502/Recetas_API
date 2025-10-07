<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use OA\Annotations as OA;

class UsuarioController extends Controller
{
    /**
     * @OA\Tag(
     *     name="Usuario",
     *     description="Operaciones sobre los usuarios"
     * )
     */
     public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (! $usuario || ! Hash::check($request->password, $usuario->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $token = $usuario->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Usuario"},
     *     summary="Cerrar sesión del usuario",
     *     @OA\Response(response=200, description="Sesión cerrada correctamente"),
     *     @OA\Response(response=401, description="No autorizado")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     tags={"Usuario"},
     *     summary="Obtener todos los usuarios",
     *     @OA\Response(response=200, description="Lista de usuarios")
     * )
     */
    public function index()
    {
        return Usuario::all();
    }

    /**
     * @OA\Post(
     *     path="/api/usuarios",    
     *     tags={"Usuario"},
     *     summary="Crear un nuevo usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Juan Perez"),
     *             @OA\Property(property="email", type="string", example="juanperez@gmail.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Usuario creado exitosamente"),
     *     @OA\Response(response=400, description="Solicitud incorrecta")
     * )
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios,email',
            'password' => 'required|string|min:6',
           
        ]);
        
        $usuario = Usuario::create($request->all());

        return response()->json(['id' => $usuario->id],201);


    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/{id}",
     *     tags={"Usuario"},
     *     summary="Obtener un usuario por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Usuario encontrado"),
     *     @OA\Response(response=404, description="Usuario no encontrado")
     * )
     */
    public function show(string $id)
    {

        $usuario = Usuario::select('name', 'email')->find($id);
         if(!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'],404);
        }
        return  response()->json($usuario,200);
    }

    /**
     * @OA\Put(
     *     path="/api/usuarios/{id}",
     *     tags={"Usuario"},
     *     summary="Actualizar un usuario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="Juan Perez"),
     *             @OA\Property(property="email", type="string", example="juanperez@gmail.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Usuario actualizado exitosamente"),
     *     @OA\Response(response=404, description="Usuario no encontrado")                                   
     * )                    
     */
    public function update(Request $request, string $id)
    {
        

        $usuario  = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:usuarios,email,' . $usuario->id,
        ]);

        $usuario->update($request->all());

        return response()->json([
            'message' => 'Usuario actualizado correctamente',
            'usuario' => $usuario
        ], 200);


    }

     /**
     * @OA\Delete(
     *     path="/api/usuarios/{id}",
     *     tags={"Usuario"},
     *     summary="Eliminar un usuario",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Usuario eliminado exitosamente"),
     *     @OA\Response(response=404, description="Usuario no encontrado")                                   
     * )    
     */
    public function destroy(string $id)
    {
       

        $usuario  = Usuario::find($id);
        if(!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'],404);
        }

        $usuario ->delete();

        return response()->json(['message','Usuario borrado correctamente',200]);


    }
}
