@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Estudiantes</h2>
    
    <!-- Mensajes de éxito -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mostrar el botón de agregar solo para administrador, profesor y director -->
    @if (Auth::user()->role == 'administrador' || Auth::user()->role == 'profesor' || Auth::user()->role == 'director')
        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Agregar Estudiante</a>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Sede</th>
                <th>Programa Académico</th>
                <th>Ciudad de Grado</th>
                <th>Identificación</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->apellido }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->sede }}</td>
                    <td>{{ $student->programa_academico }}</td>
                    <td>{{ $student->ciudad_grado }}</td>
                    <td>{{ $student->identificacion }}</td>
                    <td>{{ $student->telefono }}</td>
                    <td>
                        <!-- Mostrar opciones de editar y eliminar solo para administrador y director -->
                        @if (Auth::user()->role == 'administrador' || Auth::user()->role == 'director')
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Editar</a>

                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        @endif

                        <!-- Botón para ver detalles del estudiante -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#studentModal{{ $student->id }}">
                            Ver
                        </button>

                        <!-- Modal de Detalles del Estudiante -->
                        <div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="studentModalLabel">Detalles de {{ $student->name }} {{ $student->apellido }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Email:</strong> {{ $student->email }}</p>
                                        <p><strong>Sede:</strong> {{ $student->sede }}</p>
                                        <p><strong>Programa Académico:</strong> {{ $student->programa_academico }}</p>
                                        <p><strong>Ciudad de Grado:</strong> {{ $student->ciudad_grado }}</p>
                                        <p><strong>Identificación:</strong> {{ $student->identificacion }}</p>
                                        <p><strong>Teléfono:</strong> {{ $student->telefono }}</p>

                                        <!-- Mostrar la imagen si está disponible -->
                                        @if ($student->imagen)
                                            <p><strong>Imagen:</strong></p>
                                            <img src="data:image/jpeg;base64,{{ base64_encode($student->imagen) }}" alt="Imagen del Estudiante" class="img-thumbnail" style="max-width: 200px;">
                                        @else
                                            <p><strong>Imagen:</strong> No disponible</p>
                                        @endif

                                        <!-- Mostrar el enlace al archivo PDF si está disponible -->
                                        @if ($student->titulo)
                                            <p><strong>Título (PDF):</strong> <a href="{{ Storage::url($student->titulo) }}" target="_blank">Ver PDF</a></p>
                                        @else
                                            <p><strong>Título (PDF):</strong> No disponible</p>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <!-- Incluir los scripts necesarios para los modales (Bootstrap JS) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
