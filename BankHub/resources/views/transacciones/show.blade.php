@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detalles de la Transacción</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ID: {{ $transaccion->id }}</h5>
            <p class="card-text">Cuenta Bancaria ID: {{ $transaccion->cuenta_bancaria_id }}</p>
            <p class="card-text">Tipo de Transacción: {{ $transaccion->tipo_transaccion }}</p>
            <p class="card-text">Monto: {{ $transaccion->monto }}</p>
            <p class="card-text">Fecha de Transacción: {{ $transaccion->fecha_transaccion }}</p>
        </div>
    </div>
</div>
@endsection
