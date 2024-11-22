<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;



Route::get('/', [StudentController::class, 'showStudents'])->name('students');




// Rutas de autenticación
Auth::routes();

// Rutas para manejar estudiantes accesibles para cualquier usuario autenticado
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [StudentController::class, 'index'])->name('home'); // Mostrar lista de estudiantes

    // Rutas para manejar estudiantes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index'); // Listar estudiantes
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create'); // Mostrar formulario para crear un estudiante
    Route::post('/students', [StudentController::class, 'store'])->name('students.store'); // Almacenar estudiante

    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit'); // Mostrar formulario para editar un estudiante
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update'); // Actualizar estudiante

    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy'); // Eliminar estudiante


    // Ruta para la vista del profesor
    Route::get('/profesor', [ProfesorController::class, 'index'])->name('profesor.index');
    Route::get('/plantilla', [StudentController::class, 'index']);
    Route::get('/plantilla', [StudentController::class, 'showStudents']);

});


