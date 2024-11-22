@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Información Personal Egresado</h1>

        <!-- Agregar enctype para subir archivos -->
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

<!-- Campo para SEDE -->
            <div class="form-group">
                <label for="sede">Sede:</label>
                <input type="sede" name="sede" class="form-control" required>
            </div>


            <!-- Campo para Programa Academico -->
            <div class="form-group">
                <label for="programa_academico">Programa Academico:</label>
                <input type="programa_academico" name="programa_academico" class="form-control" required>
            </div>



            <!-- Campo para Programa Academico -->
            <div class="form-group">
                <label for="ciudad_grado">Ciudad-Grado:</label>
                <input type="ciudad_grado" name="ciudad_grado" class="form-control" required>
            </div>



         

             <!-- Campo para Programa Identificacion -->
             <div class="form-group">
                <label for="identificacion">Identificación:</label>
                <input type="identificacion" name="identificacion" class="form-control" required>
            </div>



               <!-- Campo para Telefono -->
               <div class="form-group">
                <label for="telefono">Telefono:</label>
                <input type="telefono" name="telefono" class="form-control" required>
            </div>




             <!-- Campo para subir la imagen -->
             <div class="form-group">
                <label for="titulo"><lb> Titulo:</lb> </label>
                <input type="file" name="titulo"  id="titulo" class="form-control">
            </div>


        


<br>
            <!-- Campo para subir la imagen -->
            <div class="form-group">
                <label for="imagen"><lb> Imagen:</lb> </label>
                <input type="file" name="imagen" class="form-control">
            </div>
<br>
            <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
    </div>
@endsection
