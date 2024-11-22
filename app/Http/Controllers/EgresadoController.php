<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class ProfesorController extends Controller
{
    public function index()
    {
        // Obtener la información del profesor autenticado
        $profesor = Auth::user();

        // Puedes filtrar la información que deseas mostrar. 
        // Por ejemplo, si tienes una relación entre el modelo User y Student:
        $students = Student::where('profesor_id', $profesor->id)->get();

        return view('profesor.index', compact('students'));
    }
}
