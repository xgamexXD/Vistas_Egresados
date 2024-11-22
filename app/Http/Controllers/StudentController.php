<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    // Mostrar la lista de estudiantes para el profesor autenticado
    public function index()
{
    
    if (Auth::user()->role == 'administrador') {
        // Si es administrador, muestra todos los estudiantes
        $students = Student::all();
    } else {
        // Si no es administrador, muestra solo los estudiantes relacionados con el usuario
        $students = Student::where('user_id', Auth::id())->get();
    }

    return view('home', ['students' => $students]);

   
    
        // Si es administrador, muestra todos los estudiantes
    
    $students = Student::all();
    return view('plantilla', compact('students'));
    
}


    public function student()
    {
        // Filtrar estudiantes solo del profesor autenticado
        $students = Student::where('user_id', Auth::id())->get();
        return view('students.index', compact('students'));
    }

    public function showStudents()
    {
        // Obtener todos los estudiantes
        $students = Student::all();
    
        // Pasar los estudiantes a la vista
        return view('plantilla', compact('students'));
    }
    
    // Mostrar el formulario para crear un estudiante
    public function create()
    {
        return view('students.create');
    }

    // Almacenar un nuevo estudiante
    public function store(Request $request)
    {
        // Validar los datos de entrada, incluyendo la imagen y el archivo PDF
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:students,email',
            'apellido' => 'required',
            'sede' => 'required',
            'programa_academico' => 'required',
            'ciudad_grado' => 'required',
            'identificacion' => 'required|numeric',
            'telefono' => 'required|numeric',
            'imagen' => 'nullable|image|max:2048',
            'titulo' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Crear un nuevo estudiante
        $student = new Student();
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->apellido = $request->input('apellido');
        $student->sede = $request->input('sede');
        $student->programa_academico = $request->input('programa_academico');
        $student->ciudad_grado = $request->input('ciudad_grado');
        $student->identificacion = $request->input('identificacion');
        $student->telefono = $request->input('telefono');

        // Almacenar el ID del profesor que crea el estudiante
        $student->user_id = Auth::id();

        // Manejar la imagen (si se carga una)
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('images', 'public');
            $student->imagen = $imagePath;
        }

        // Manejar el archivo PDF del título (si se carga uno)
        if ($request->hasFile('titulo')) {
            $file = $request->file('titulo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('storage/PDF');
            $file->move($destinationPath, $fileName);
            $student->titulo = 'storage/PDF/' . $fileName;
        }

        // Guardar el nuevo estudiante en la base de datos
        $student->save();

        return redirect()->route('students.index')->with('success', 'Estudiante agregado exitosamente.');
    }

    // Mostrar el formulario para editar un estudiante
    public function edit($id)
{
    // Permitir que el administrador edite cualquier estudiante
    if (Auth::user()->role == 'administrador') {
        $student = Student::findOrFail($id);
    } else {
        // Si no es administrador, solo se permite editar estudiantes propios
        $student = Student::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    }

    return view('students.edit', compact('student'));
}

    // Eliminar un estudiante
    public function destroy($id)
    {
        // Buscar al estudiante
        $student = Student::where('id', $id)->first();
    
        // Verificar si el usuario es administrador o si el estudiante le pertenece al usuario autenticado
        if (Auth::user()->role == 'administrador' || $student->user_id == Auth::id()) {
            
            // Eliminar la imagen del estudiante si existe
            if ($student->imagen) {
                Storage::disk('public')->delete($student->imagen);
            }
    
            // Eliminar el archivo PDF del título si existe
            if ($student->titulo) {
                $pdfPath = public_path($student->titulo);
                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }
            }
    
            // Eliminar el estudiante de la base de datos
            $student->delete();
    
            return redirect()->route('students.index')->with('success', 'Estudiante eliminado exitosamente.');
        }
    
        // Si el usuario no tiene permisos para eliminar el estudiante, se le deniega el acceso
        return redirect()->route('students.index')->with('error', 'No tienes permisos para eliminar este estudiante.');
    }
    

    // Actualizar la información de un estudiante
    public function update(Request $request, $id)
    {
        // Comprobar si el usuario es administrador o si el estudiante pertenece al profesor autenticado
        $student = Student::where('id', $id)->first();
    
        if (Auth::user()->role == 'administrador' || $student->user_id == Auth::id()) {
            // Validar los datos de entrada
            $request->validate([
                'name' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'sede' => 'required|string|max:255',
                'programa_academico' => 'required|string|max:255',
                'ciudad_grado' => 'required|string|max:255',
                'identificacion' => 'required|string|max:255',
                'telefono' => 'required|string|max:255',
            ]);
    
            // Actualizar el estudiante (exceptuando los archivos)
            $student->update($request->except(['titulo', 'imagen']));
    
            // Manejar el archivo PDF del título (si se carga uno)
            if ($request->hasFile('titulo')) {
                if ($student->titulo && file_exists(public_path($student->titulo))) {
                    unlink(public_path($student->titulo));
                }
    
                $file = $request->file('titulo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('storage/PDF'), $filename);
                $student->titulo = 'storage/PDF/' . $filename;
            }
    
            // Manejar la imagen (si se carga una)
            if ($request->hasFile('imagen')) {
                if ($student->imagen && file_exists(public_path('storage/images/' . $student->imagen))) {
                    unlink(public_path('storage/images/' . $student->imagen));
                }
    
                $path = $request->file('imagen')->storeAs('images', $request->file('imagen')->getClientOriginalName(), 'public');
                $student->imagen = $path;
            }
    
            // Guardar el estudiante actualizado
            $student->save();
    
            return redirect()->route('students.index')->with('success', 'Estudiante actualizado con éxito.');
        }
    
        // Si el usuario no es administrador ni propietario del estudiante, se le niega el acceso
        return redirect()->route('students.index')->with('error', 'No tienes permisos para actualizar este estudiante.');
    }



    
}
