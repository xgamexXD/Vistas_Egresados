<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Landing Page - Start Bootstrap Theme</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" type="text/css" />
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <!-- Botón de Dashboard o Logout cuando el usuario está autenticado -->
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <!-- Botón de Login cuando el usuario no está autenticado -->
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            <!-- Si tienes habilitado el registro, muestra este botón -->
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="masthead">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="text-center text-white">
                        <b><h1 class="mb-5">¡Únete a esta familia!</h1></b>
                        <h2 class="mb-5">¡Nuestros mejores egresados están aquí! Únete y descubre todo lo que puedes lograr.</h2>
                        <!-- Signup form -->
                        <form class="form-subscribe" id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <!-- Email address input -->
                            <div class="row">
                                <div class="col">
                                    <input class="form-control form-control-lg" id="emailAddress" type="email" placeholder="Email Address" data-sb-validations="required,email" />
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:required">Se requiere dirección de correo electrónico.</div>
                                    <div class="invalid-feedback text-white" data-sb-feedback="emailAddress:email">Dirección de correo electrónico incorrecto.</div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
                                </div>
                            </div>
                            <!-- Submit success and error messages -->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    <p>To activate this form, sign up at</p>
                                    <a class="text-white" href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Testimonials -->
    <section class="testimonials text-center bg-light">
        <div class="container">
            <h2 class="mb-5">Nuestros Egresados Ejemplares</h2>
            <div class="row">
                @foreach($students as $student)
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <br>
                        @if($student->imagen)
                            <img class="img-fluid rounded-circle mb-3" src="{{ asset('storage/images/' . basename($student->imagen)) }}" alt="Imagen de {{ $student->name }}" style="height: 150px; width: 150px; object-fit: cover;">
                        @else
                            <img class="img-fluid rounded-circle mb-3" src="https://dummyimage.com/150x150/dee2e6/6c757d.jpg" alt="Imagen no disponible" style="height: 150px; width: 150px; object-fit: cover;">
                        @endif
                        <h5>{{ $student->name }}</h5>
                        <!-- Botón para ver detalles del estudiante -->
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#studentModal{{ $student->id }}"
                        style="font-size: 16px; font-weight: bold; padding: 5px 4px; border-width: 2px; transition: background-color 0.3s, color 0.3s, border-color 0.3s; min-width: 70px; height: 40px; text-align: center;  border-radius: 40%;"
                onmouseover="this.style.backgroundColor='#2e4e99'; this.style.color='white'; this.style.borderColor='#0056b3';"
                onmouseout="this.style.backgroundColor=''; this.style.color=''; this.style.borderColor='';">
                            <i class="fas fa-eye"></i> Ver
                        </button>
                    </div>
                </div>
<br><br>
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
                                        <img src="{{ asset('storage/images/' . basename($student->imagen)) }}" alt="Imagen de {{ $student->name }}" style="width: 130px; height: auto;">
                                    @else
                                        <p><strong>Imagen:</strong> No disponible</p>
                                    @endif
                                    <br><br>
                                </center>
                                <p><strong>Email:</strong> {{ $student->email }}</p>
                                <p><strong>Sede:</strong> {{ $student->sede }}</p>
                                <p><strong>Programa Académico:</strong> {{ $student->programa_academico }}</p>
                                <p><strong>Ciudad de Grado:</strong> {{ $student->ciudad_grado }}</p>
                                <p><strong>Identificación:</strong> {{ $student->identificacion }}</p>
                                <p><strong>Teléfono:</strong> {{ $student->telefono }}</p>
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
                @endforeach
            </div>
        </div>
    </section>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
