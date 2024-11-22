@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Estudiante</h1>

        <!-- Agregar enctype para subir archivos -->
        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" value="{{ $student->name }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" value="{{ $student->apellido }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="{{ $student->email }}" class="form-control" required>
            </div>


            <div class="form-group">
                <label for="sede">Sede:</label>
                <input type="text" name="sede" value="{{ $student->sede }}" class="form-control" required>
            </div>



            <div class="form-group">
                <label for="programa_academico">programa_academico:</label>
                <input type="text" name="programa_academico" value="{{ $student->programa_academico }}" class="form-control" required>
            </div>


            <div class="form-group">
                <label for="ciudad_grado">Ciudad grado:</label>
                <input type="text" name="ciudad_grado" value="{{ $student->ciudad_grado }}" class="form-control" required>
            </div>



            <div class="form-group">
                <label for="identificacion">Identificacion:</label>
                <input type="identificacion" name="identificacion" value="{{ $student->identificacion }}" class="form-control" required>
            </div>



            <div class="form-group">
                <label for="telefono">Telefono:</label>
                <input type="telefono" name="telefono" value="{{ $student->telefono }}" class="form-control" required>
            </div>


<br>
            
            <!-- Mostrar el título actual si existe -->
<div class="form-group">
    <label for="titulo_actual">Título actual:</label><br>
    @if ($student->titulo)
        <a href="{{ asset($student->titulo) }}" target="_blank">Ver Título</a>
    @else
        <p>No hay título cargado</p>
    @endif
</div>
<br>
<!-- Campo para subir un nuevo PDF -->
<div class="form-group">
    <label for="titulo">Cambiar Título (PDF):</label>
    <input type="file" name="titulo" id="titulo" class="form-control" accept="application/pdf">
</div>




<br>


            <!-- Mostrar la imagen actual si existe -->
            <div class="form-group">
                <label for="imagen_actual">Imagen actual:</label><br><br>
                @if ($student->imagen)
                    <img src="{{ asset('storage/' . $student->imagen) }}" alt="Imagen actual" width="150">
                @else
                    <p>No hay imagen cargada</p>
                @endif
            </div>
<br>
            <!-- Campo para subir una nueva imagen -->
            <div class="form-group">
                <label for="imagen">Cambiar imagen:</label>
                <input type="file" name="imagen" class="form-control">
            </div>
<br>
            <center><button type="submit" class="btn btn-primary">Actualizar</button></center>
        </form>
    </div>
@endsection
