@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Crear Nueva Cuenta Bancaria</h2>
    <form action="{{ route('cuentas_bancarias.store') }}" method="POST" id="createAccountForm">
        @csrf
        <div class="row">
        {{-- Selector de Persona por ID --}}
<div class="mb-3">
    <label for="persona_id">Persona ID</label>
    <select class="form-control" name="persona_id" id="persona_id">
        <option value="">Seleccione una persona por ID</option>
        @foreach($personas as $persona)
            <option value="{{ $persona->id }}">{{ $persona->id }}</option>
        @endforeach
    </select>
</div>

{{-- Selector de Persona por Nombre --}}
<div class="mb-3">
    <label for="persona_nombre">Persona Nombre</label>
    <select class="form-control" name="persona_nombre" id="persona_nombre">
        <option value="">Seleccione una persona por Nombre</option>
        @foreach($personas as $persona)
            <option value="{{ $persona->id }}">{{ $persona->nombre }} {{ $persona->apellido }}</option>
        @endforeach
    </select>
</div>

            <!-- Selector de Tipo de Cuenta -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipo_cuenta">Tipo de Cuenta</label>
                    <select class="form-control" name="tipo_cuenta" id="tipo_cuenta" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="corriente">Corriente</option>
                        <option value="ahorro">Ahorro</option>
                        <option value="inversion">Inversión</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Campo de Saldo -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="saldo">Saldo</label>
                    <input type="number" class="form-control" name="saldo" id="saldo" required>
                </div>
            </div>
            <!-- Selector de Moneda -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="moneda">Moneda</label>
                    <select class="form-control" name="moneda" id="moneda" required>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="BOB">BOB</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Crear Cuenta</button>
    </form>
</div>

@section('scripts')
<script>
    // Función para sincronizar los selectores
    function sincronizarSelectores(valorSeleccionado) {
        // Actualizar ambos selectores
        document.getElementById('persona_id').value = valorSeleccionado;
        document.getElementById('persona_nombre').value = valorSeleccionado;
    }

    // Escuchar cambios en el selector por ID
    document.getElementById('persona_id').addEventListener('change', function() {
        sincronizarSelectores(this.value);
    });

    // Escuchar cambios en el selector por Nombre
    document.getElementById('persona_nombre').addEventListener('change', function() {
        sincronizarSelectores(this.value);
    });
</script>
@endsection
@endsection
