{{-- resources/views/cuentas_bancarias/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Editar Cuenta Bancaria</h2>
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cuentas_bancarias.update', $cuenta->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_cuenta" class="form-label">Tipo de Cuenta</label>
                        <select class="form-select" id="tipo_cuenta" name="tipo_cuenta">
                            <option value="">Seleccione un tipo</option>
                            @foreach($tiposDeCuenta as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo_cuenta', $cuenta->tipo_cuenta) == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="moneda" class="form-label">Moneda</label>
                        <select class="form-select" id="moneda" name="moneda">
                            <option value="">Seleccione la moneda</option>
                            <option value="USD" {{ old('moneda', $cuenta->moneda) == 'USD' ? 'selected' : '' }}>USD - Dólar estadounidense</option>
                            <option value="EUR" {{ old('moneda', $cuenta->moneda) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            <option value="BOB" {{ old('moneda', $cuenta->moneda) == 'BOB' ? 'selected' : '' }}>BOB - Boliviano</option>
                            <!-- Agrega más monedas según necesidad -->
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="saldo" class="form-label">Saldo</label>
                    <input type="number" class="form-control" id="saldo" name="saldo" value="{{ old('saldo', $cuenta->saldo) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('cuentas_bancarias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
