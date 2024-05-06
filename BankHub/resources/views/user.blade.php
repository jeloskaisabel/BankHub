{{-- resources/views/user.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Usuario</h1>
    <p class="lead">Bienvenido, {{ auth()->user()->username }}</p>
    <div class="mb-4">
        <h2>Información Personal</h2>
        <p>Nombre: {{ auth()->user()->persona->nombre }}</p>
        <p>Email: {{ auth()->user()->persona->email }}</p>
    </div>
    <div>
        <h2>Cuentas Bancarias</h2>
        <ul class="list-group">
            @foreach (auth()->user()->persona->cuentasBancarias as $cuenta)
                <li class="list-group-item">
                    Cuenta #: {{ $cuenta->numero_cuenta }} - Saldo: ${{ $cuenta->saldo }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
