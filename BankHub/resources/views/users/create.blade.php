{{-- resources/views/users/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Usuario</h1>
    <form id="userForm" action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_usuario">Nombre de Usuario</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
        </div>
        <div class="mb-3">
            <label for="persona_id">ID de Persona</label>
            <select class="form-control" id="persona_id" name="persona_id">
                <option value="">Seleccione el ID de Persona</option>
                @foreach ($personas as $persona)
                <option value="{{ $persona->id }}">{{ $persona->id }}</option>
                @endforeach
            </select>
        </div>
        <div id="personaInfo" style="display:none;">
            <p><strong>Nombre:</strong> <span id="personaNombre"></span></p>
            <p><strong>Email:</strong> <span id="personaEmail"></span></p>
        </div>
        <div class="mb-3">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div class="mb-3">
            <label for="rol">Rol</label>
            <select class="form-control" id="rol" name="rol">
                @foreach ($roles as $role)
                <option value="{{ $role }}">{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#persona_id').change(function() {
        var personaId = $(this).val();
        if (personaId) {
            $.ajax({
                url: '/personas/' + personaId + '/data',
                type: 'GET',
                success: function(response) {
                    $('#personaInfo').show();
                    $('#personaNombre').text(response.nombre);
                    $('#personaEmail').text(response.email);
                },
                error: function() {
                    $('#personaInfo').hide();
                    alert('No se pudo cargar la información de la persona.');
                }
            });
        } else {
            $('#personaInfo').hide();
        }
    });
});
</script>
@endsection
