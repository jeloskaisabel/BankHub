{{-- resources/views/cuentas_bancarias/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cuentas Bancarias</h1>
    <div class="row mb-3">
        <div class="col-sm-4">
            <form action="{{ route('cuentas_bancarias.index') }}" method="GET">
                <div class="input-group">
                    <select name="tipo_cuenta" class="form-select">
                        <option value="">Todos los tipos</option>
                        @foreach($tiposDeCuenta as $tipo)
                            <option value="{{ $tipo }}" {{ request('tipo_cuenta') == $tipo ? 'selected' : '' }}>{{ ucfirst($tipo) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
        <div class="col-sm-8 text-end">
            <a href="{{ route('cuentas_bancarias.create') }}" class="btn btn-success">Crear nueva cuenta</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titular</th>
                    <th>Tipo de Cuenta</th>
                    <th>Saldo</th>
                    <th>Moneda</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cuentas as $cuenta)
                <tr>
                    <td>{{ $cuenta->id }}</td>
                    <td>{{ $cuenta->persona->nombre }} {{ $cuenta->persona->apellido }}</td>
                    <td>{{ ucfirst($cuenta->tipo_cuenta) }}</td>
                    <td>{{ number_format($cuenta->saldo, 2) }}</td>
                    <td>{{ $cuenta->moneda }}</td>
                    <td>{{ $cuenta->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('cuentas_bancarias.show', $cuenta) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('cuentas_bancarias.edit', $cuenta) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('cuentas_bancarias.destroy', $cuenta) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $cuentas->appends(request()->query())->links() }}
    </div>
</div>
@endsection
