<?php

namespace App\Http\Controllers;

use App\Models\InternStudent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class InternStudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome');
    }

    public function findStudentForDni(Request $request)
    {
        try {
            // Validación simple solo para DNI
            $request->validate([
                'dni' => 'required|numeric|digits:8',
            ], [
                'dni.required' => 'El DNI es requerido',
                'dni.numeric' => 'El DNI debe ser numérico',
                'dni.digits' => 'El DNI debe tener 8 dígitos',
            ]);

            $student = InternStudent::where('dni', $request->dni)->first();

            if (!$student) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se encontró el estudiante con el DNI ingresado',
                    'data' => null
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Estudiante encontrado',
                'data' => $student
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->validator->errors()->first(),
                'data' => null
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error del servidor: ' . $ex->getMessage(),
                'data' => null
            ]);
        }
    }
}
