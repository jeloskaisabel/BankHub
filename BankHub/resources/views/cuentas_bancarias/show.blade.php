{{-- resources/views/cuentas_bancarias/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detalle de la Cuenta Bancaria</h2>
    <div class="card">
        <div class="card-header">
            Información de la Cuenta
        </div>
        <div class="card-body">
            <h5 class="card-title">Titular: {{ $cuenta->persona->nombre }} {{ $cuenta->persona->apellido }}</h5>
            <p class="card-text"><strong>Tipo de Cuenta:</strong> {{ ucfirst($cuenta->tipo_cuenta) }}</p>
            <p class="card-text"><strong>Saldo:</strong> {{ number_format($cuenta->saldo, 2) }} {{ $cuenta->moneda }}</p>
            <p class="card-text"><strong>Fecha de Creación:</strong> {{ $cuenta->created_at->format('d/m/Y') }}</p>
            <p class="card-text"><strong>Fecha de Última Modificación:</strong> {{ $cuenta->updated_at->format('d/m/Y') }}</p>
            <a href="{{ route('cuentas_bancarias.edit', $cuenta->id) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('cuentas_bancarias.index') }}" class="btn btn-secondary">Volver a la Lista</a>
        </div>
    </div>
</div>
@endsection
