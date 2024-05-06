@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Montos por Departamento</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Departamento</th>
                <th>Total Monto</th>
                <th>Categoría Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resultados as $resultado)
            <tr>
                <td>{{ $resultado->departamento }}</td>
                <td>{{ number_format($resultado->total_monto, 2) }}</td>
                <td>{{ $resultado->categoria_monto }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
