@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Registrar Nueva Persona</h2>
    <div class="card">
        <div class="card-header">
            Llena la información de la persona
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('personas.store') }}" method="POST" id="addPersonForm">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                    <small id="nombreHelp" class="form-text text-muted">Introduce el nombre de la persona.</small>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                    <small id="apellidoHelp" class="form-text text-muted">Introduce el apellido de la persona.</small>
                </div>
                <div class="mb-3">
                    <label for="documento_identidad" class="form-label">Documento de Identidad</label>
                    <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" required>
                    <small id="documentoIdentidadHelp" class="form-text text-muted">Introduce el número de documento de identidad sin espacios ni guiones.</small>
                </div>
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                    <small id="fechaNacimientoHelp" class="form-text text-muted">Introduce la fecha de nacimiento.</small>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <small id="emailHelp" class="form-text text-muted">Introduce una dirección de correo válida.</small>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono">
                    <small id="telefonoHelp" class="form-text text-muted">Introduce un número de teléfono de contacto.</small>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <textarea class="form-control" id="direccion" name="direccion" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="departamento" class="form-label">Departamento</label>
                    <select class="form-select" id="departamento" name="departamento" required>
                        <option value="" selected>Selecciona un departamento</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento }}">{{ $departamento }}</option>
                        @endforeach
                    </select>
                    <small id="departamentoHelp" class="form-text text-muted">Selecciona el departamento de la persona.</small>
                </div>
                <button type="submit" class="btn btn-success">Registrar</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var addPersonForm = document.getElementById('addPersonForm');
    addPersonForm.addEventListener('submit', function (e) {
        // Prevent form submission if any validation fails
        // Ejemplo de validación sencilla
        if (!addPersonForm.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            // Opcional: implementar feedback visual
            // addPersonForm.classList.add('was-validated');
        }
    });
});
</script>
@endsection
