{{-- resources/views/users/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuario</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="username">Nombre de Usuario</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required disabled>
        </div>
        <div class="mb-3">
            <label for="persona_id">ID de Persona</label>
            <input type="text" class="form-control" id="persona_id" name="persona_id" value="{{ $user->persona_id }}" required disabled>
        </div>
        <div id="personaInfo">
            <p><strong>Nombre:</strong> <span id="personaNombre">{{ $user->persona->nombre }}</span></p>
            <p><strong>Email:</strong> <span id="personaEmail">{{ $user->persona->email }}</span></p>
        </div>
        <div class="mb-3">
            <label for="password">Nueva Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <div class="mb-3">
            <label for="rol">Rol</label>
            <select class="form-control" id="rol" name="rol">
                @foreach ($roles as $role)
                <option value="{{ $role }}" {{ $user->rol == $role ? 'selected' : '' }}>{{ $role }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
