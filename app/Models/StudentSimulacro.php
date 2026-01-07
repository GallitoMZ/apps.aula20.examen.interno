<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSimulacro extends Model
{
    use HasFactory;

    // Definimos explícitamente la tabla
    protected $table = 'students_simulacros';

    // Campos que permitimos llenar masivamente
    protected $fillable = [
        'dni',
        'fullname',
        'sede',
        'area',
        'carrera',
        'nota',
        'beneficio',
    ];

    public static function findByDni($dni)
    {
        return self::where('dni', $dni);
    }

    // Accesor para buscar por fullname
    public static function findByFullname($fullname)
    {
        return self::where('fullname', 'like', '%' . $fullname . '%');
    }
}
