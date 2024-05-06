@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Agregar Nueva Transacción</h2>
    <form action="{{ route('transacciones.store') }}" method="POST">
        @csrf
        <div class="form-group">
    <label for="cuenta_bancaria_id">Cuenta Bancaria ID:</label>
    <select class="form-control" id="cuenta_bancaria_id" name="cuenta_bancaria_id" required>
        @foreach($cuentasBancarias as $id)
            <option value="{{ $id }}">{{ $id }}</option>
        @endforeach
    </select>
</div>
        <div class="form-group">
            <label for="tipo_transaccion">Tipo de Transacción:</label>
            <input type="text" class="form-control" id="tipo_transaccion" name="tipo_transaccion" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto:</label>
            <input type="text" class="form-control" id="monto" name="monto" required>
        </div>
        <div class="form-group">
            <label for="fecha_transaccion">Fecha de Transacción:</label>
            <input type="datetime-local" class="form-control" id="fecha_transaccion" name="fecha_transaccion" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
