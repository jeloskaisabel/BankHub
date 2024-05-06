@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Listado de Personas</h2>
    <a href="{{ route('personas.create') }}" class="btn btn-success mb-3">Agregar Nueva Persona</a>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Documento de Identidad</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Departamento</th> <!-- Nueva columna para el departamento -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($personas as $persona)
                    <tr>
                        <td>{{ $persona->id }}</td>
                        <td>{{ $persona->nombre }}</td>
                        <td>{{ $persona->apellido }}</td>
                        <td>{{ $persona->documento_identidad }}</td>
                        <td>{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}</td>
                        <td>{{ $persona->email }}</td>
                        <td>{{ $persona->telefono }}</td>
                        <td>{{ $persona->departamento }}</td> <!-- Mostrar el departamento -->
                        <td>
                            <a href="{{ route('personas.show', $persona->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('personas.edit', $persona->id) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('personas.destroy', $persona->id) }}" method="POST" class="d-inline">
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
    {{ $personas->links() }} <!-- Paginación -->
</div>
@endsection
