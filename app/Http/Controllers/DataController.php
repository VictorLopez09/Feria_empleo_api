<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Colonia;
use App\Models\Estado;
use Illuminate\Http\Request;

class DataController extends Controller
{


    public function StateShow(Request $request)
    {
        $States =  Estado::all();
        return $States;
    }

    public function CityShow(Request $request)
    {

        $existingState = Ciudad::where('clave_estado', $request->clave_estado)
            ->limit(1)
            ->exists();

        if (!$existingState) {
            // Si la ciudad ya existe, puedes manejar la situación aquí,
            // ya sea mostrando un mensaje de error, redirigiendo a otra página, etc.
            return response()->json([
                'message' => 'No se encontro el estado!',
            ], 404);
        }

        $Citys = Ciudad::where('clave_estado', $request->clave_estado)->get();
        return $Citys;
    }

    public function NeighborhoodShow(Request $request)
    {
        $existingCity = Ciudad::where('clave_ciudad', $request->clave_ciudad)
            ->limit(1)
            ->exists();

        if (!$existingCity) {
            // Si la ciudad ya existe, puedes manejar la situación aquí,
            // ya sea mostrando un mensaje de error, redirigiendo a otra página, etc.
            return response()->json([
                'message' => 'No se encontro la ciudad!',
            ], 404);
        }

        $Neighborhood = Colonia::where('clave_ciudad', $request->clave_ciudad)->get();
        return $Neighborhood;
    }
}
