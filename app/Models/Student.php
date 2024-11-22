<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Definir qué campos se pueden llenar
    protected $fillable = [
        'name',
        'email',
        'apellido',
        'sede',
        'programa_academico',
        'ciudad_grado',
        'identificacion',
        'telefono',
        'imagen',
        'titulo', // Campo para almacenar la ruta del archivo PDF
    ];
}
