<?php

namespace App\Http\Controllers;

use App\Models\Feria;
use App\Models\Registraseferia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FairController extends Controller
{
    public function RegisterFair(Request $request)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'clave_feria' => 'required|integer',
            'curp' => 'required|string|max:18',
            'medio' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Crea un nuevo registro utilizando el modelo Registraseferia
        $registro = Registraseferia::create([
            'clave_feria' => $request->clave_feria,
            'curp' => $request->curp,
            'medio' => $request->medio,
        ]);

        // Verifica si el registro fue creado con éxito
        if ($registro) {
            return response()->json(['mensaje' => 'Registro exitoso'], 201);
        } else {
            return response()->json(['mensaje' => 'Error al registrar'], 500);
        }
    }

    public function FairShow()
    {
        $fairs = Feria::all();
        return $fairs;
    }


    public function BadgeShow()
    {
        $resultado = RegistraseFeria::join('feria', 'registraseferia.clave_feria', '=', 'feria.clave_feria')
            ->select('registraseferia.clave_registro as id_registro', 'feria.clave_feria as id_feria', 'feria.fecha as fecha_feria')
            ->orderByRaw('ABS(DATEDIFF(feria.fecha, CURDATE()))')
            ->limit(1)
            ->get();

        return $resultado;
    }
}
