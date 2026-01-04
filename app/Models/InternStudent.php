<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternStudent extends Model
{
    use HasFactory;
    protected $table = 'intern_students';
    protected $fillable = [
        'dni',
        'fullname',
        'sede',
        'area',
        'carrera',
        'nota',
        'beneficio'
    ];
    // Accesor para buscar por DNI
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
