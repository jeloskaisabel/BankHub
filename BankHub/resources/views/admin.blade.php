{{-- resources/views/admin.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Panel de Administración</h1>
    <div class="list-group">
        <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">Administrar Usuarios</a>
        <a href="{{ route('personas.index') }}" class="list-group-item list-group-item-action">Administrar Personas</a>
        <a href="{{ route('cuentas_bancarias.index') }}" class="list-group-item list-group-item-action">Administrar Cuentas Bancarias</a>
        <a href="{{ route('transacciones.index') }}" class="list-group-item list-group-item-action">Administrar Transacciones</a>
    </div>
</div>
@endsection
