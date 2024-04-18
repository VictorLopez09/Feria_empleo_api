<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'curp' => 'required|unique:usuario,curp',
            'rfc' => 'required|unique:usuario,rfc',
            'nombre' => 'required',
            'paterno' => 'required',
            'materno' => 'required',
            'sexo' => 'required',
            'clave_estado' => 'required',
            'clave_ciudad' => 'required',
            'clave_colonia' => 'required',
            'calle' => 'required',
            'telefono' => 'required|digits:10', // Asumiendo que el número de teléfono tiene exactamente 10 dígitos
            'email' => 'required|email|unique:usuario',
            'contrasena' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $usuario = Usuario::create([
            'curp' => $request->curp,
            'rfc' => $request->rfc,
            'nombre' => $request->nombre,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'sexo' => $request->sexo,
            'clave_estado' => $request->clave_estado,
            'clave_ciudad' => $request->clave_ciudad,
            'clave_colonia' => $request->clave_colonia,
            'calle' => $request->calle,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'contrasena' => Hash::make($request->contrasena),
        ]);

        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'data' => $usuario,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:usuario,email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'contrasena');
        $user = Usuario::where('email', $credentials['email'])->first();

        if (!Hash::check($credentials['contrasena'], $user->contrasena)) {
            return response()->json(['message' => 'La contraseña es incorrecta'], 401);
        }

        $usuario = Usuario::where('email', $request->email)->firstOrFail();
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => '¡Hola, ' . $user->nombre . '!',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function show(Request $request)
    {
        $credentials = $request->only('email');
        $user = Usuario::where('email', $credentials['email'])->first();
        return response()->json([
            'message' => '¡Hola, ' . $user->nombre . '!',
            'user ' => $user,
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }
}
