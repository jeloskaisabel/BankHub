{{-- resources/views/users/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles del Usuario</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $user->username }}</h5>
            <p class="card-text">ID de Persona: {{ $user->persona_id }}</p>
            <p class="card-text">Nombre de Persona: {{ $user->persona->nombre }}</p>
            <p class="card-text">Email de Persona: {{ $user->persona->email }}</p>
            <p class="card-text">Rol: {{ $user->rol }}</p>
            <a href="{{ route('users.index') }}" class="btn btn-primary">Volver a la lista</a>
        </div>
    </div>
</div>
@endsection
