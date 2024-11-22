@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Egresados</h2>
    
    <!-- Mensajes de éxito -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mostrar el botón de agregar solo para administrador, profesor y director -->
    @if (Auth::user()->role == 'administrador' || Auth::user()->role == 'profesor' || Auth::user()->role == 'director')
        <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Agregar Informaciónde Egresado</a>
    @endif
    
    <table class="table">
        <thead>
            <tr style="text-align: center;">
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
                <tr style="text-align: center; vertical-align: middle;">
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->apellido }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->sede }}</td>
                    <td>{{ $student->programa_academico }}</td>
                    <td>{{ $student->ciudad_grado }}</td>
                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; ">{{ $student->identificacion }}</td>
                    <td style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; ">{{ $student->telefono }}</td>

                    
                    <td>


                 
               <!-- Mostrar opciones de editar y eliminar solo para administrador y director -->
                
               @if (Auth::user()->role == 'administrador' || Auth::user()->role == 'director'  || Auth::user()->role == 'profesor')
    <div class="btn-group" role="group" aria-label="Acciones" style="display: flex; gap: 10px; margin-top: 10px; ">
        <!-- Botón de editar -->
        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline-primary btn-sm"
           style="font-size: 16px; font-weight: bold; padding: 5px 4px; border-width: 2px; transition: background-color 0.3s, color 0.3s, border-color 0.3s; min-width:70px; height: 40px; text-align: center; border-radius: 40%;"
           onmouseover="this.style.backgroundColor='#0056b3'; this.style.color='white'; this.style.borderColor='#0056b3';"
           onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';">
            <i class="fas fa-edit"></i> Editar
        </a>

        <!-- Formulario de eliminar con botón personalizado -->
        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm"
            style="font-size: 16px; font-weight: bold; padding: 5px 4px; border-width: 2px; transition: background-color 0.3s, color 0.3s, border-color 0.3s; min-width: 70px; height: 40px; text-align: center; border-radius: 40%;"
onmouseover="this.style.backgroundColor='#ff0000'; this.style.color='white'; this.style.borderColor='#ff0000';"
onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';"
                    onmouseover="this.style.backgroundColor='#0056b3'; this.style.color='white'; this.style.borderColor='#0056b3';"
                    onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar este estudiante?');">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </form>

        <!-- Botón para ver detalles del estudiante -->
        <button type="button" class="btn btn-outline-info btn-sm"
                style="font-size: 16px; font-weight: bold; padding: 5px 4px; border-width: 2px; transition: background-color 0.3s, color 0.3s, border-color 0.3s; min-width: 70px; height: 40px; text-align: center;  border-radius: 40%;"
                onmouseover="this.style.backgroundColor='#0056b3'; this.style.color='white'; this.style.borderColor='#0056b3';"
                onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';"
                data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}">
            <i class="fas fa-eye"></i> Ver
        </button>
    </div>
@endif


             <!--FIN OPCIONES CRUD -->

                        <!-- Modal de Detalles del Estudiante -->
                        <div class="modal fade" id="studentModal{{ $student->id }}" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="studentModalLabel">Detalles de {{ $student->name }} {{ $student->apellido }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <center>
                                        @if ($student->imagen)
                                            
                                            <img   src="{{ asset('storage/images/' . basename($student->imagen)) }}" alt="Imagen de {{ $student->name }}" style="width: 130px; height: auto; " >
                                        @else
                                            <p><strong>Imagen:</strong> No disponible</p>
                                        @endif
                                        <br>
                                        <br>
                                    </center>
                                        <p><strong>Email:</strong> {{ $student->email }}</p>
                                        <p><strong>Sede:</strong> {{ $student->sede }}</p>
                                        <p><strong>Programa Académico:</strong> {{ $student->programa_academico }}</p>
                                        <p><strong>Ciudad de Grado:</strong> {{ $student->ciudad_grado }}</p>
                                        <p><strong>Identificación:</strong> {{ $student->identificacion }}</p>
                                        <p><strong>Teléfono:</strong> {{ $student->telefono }}</p>

                                        <!-- Mostrar la imagen si está disponible -->
                                    
                                        @if ($student->titulo)
                                            <p><strong>Título (PDF):</strong> 
                                                <a href="{{ asset($student->titulo) }}" target="_blank">Ver PDF</a>
                                            </p>
                                        @else
                                            <p><strong>Título (PDF):</strong> No disponible</p>
                                        @endif



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
    <!-- Incluir los scripts necesarios para los modales (Bootstrap 5 JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection