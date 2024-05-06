@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detalles de la Persona</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Información Personal
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $persona->nombre }} {{ $persona->apellido }}</h5>
                    <p class="card-text"><strong>Documento de Identidad:</strong> {{ $persona->documento_identidad }}</p>
                    <p class="card-text"><strong>Fecha de Nacimiento:</strong> {{ $persona->fecha_nacimiento ? \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('Y-m-d') : '' }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $persona->email }}</p>
                    <p class="card-text"><strong>Teléfono:</strong> {{ $persona->telefono }}</p>
                    <p class="card-text"><strong>Dirección:</strong> {{ $persona->direccion }}</p>
                    <p class="card-text"><strong>Departamento:</strong> {{ $persona->departamento ?? 'Sin departamento' }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Cuentas Bancarias
                </div>
                <ul class="list-group list-group-flush">
                @if($persona->cuentasBancarias->isEmpty())
                    <p>No hay cuentas bancarias asociadas.</p>
                @else
                    @foreach ($persona->cuentasBancarias as $cuenta)
                        <div class="list-group-item">
                            <h5 class="mb-3">Cuenta Nº: {{ $cuenta->id }}</h5>
                            <p><strong>Tipo de cuenta:</strong> {{ ucfirst($cuenta->tipo_cuenta) }}</p>
                            <p><strong>Saldo:</strong> {{ number_format($cuenta->saldo, 2) }} {{ $cuenta->moneda }}</p>
                            <p><strong>Creado en:</strong> {{ $cuenta->created_at->format('d/m/Y H:i:s') }}</p>
                            <p><strong>Última actualización:</strong> {{ $cuenta->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    @endforeach
                @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('personas.edit', $persona->id) }}" class="btn btn-warning">Editar</a>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
</div>
@endsection
