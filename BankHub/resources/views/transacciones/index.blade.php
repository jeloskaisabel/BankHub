@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Listado de Transacciones</h2>
    <a href="{{ route('transacciones.create') }}" class="btn btn-success mb-3">Agregar Nueva Transacción</a>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Cuenta Bancaria ID</th>
                    <th>Tipo de Transacción</th>
                    <th>Monto</th>
                    <th>Fecha de Transacción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transacciones as $transaccion)
                    <tr>
                        <td>{{ $transaccion->id }}</td>
                        <td>{{ $transaccion->cuenta_bancaria_id }}</td>
                        <td>{{ $transaccion->tipo_transaccion }}</td>
                        <td>{{ $transaccion->monto }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaccion->fecha_transaccion)->format('d/m/Y H:i:s') }}</td>
                        <td>
                            <a href="{{ route('transacciones.show', $transaccion->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('transacciones.edit', $transaccion->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('transacciones.destroy', $transaccion->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Paginación -->
    {{ $transacciones->links() }}
</div>
@endsection
