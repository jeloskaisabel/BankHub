<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use App\Utils\Departamentos;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::paginate(10);
        return view('personas.index', compact('personas'));
    }

    public function create()
    {
        $departamentos = Departamentos::obtenerLista();
        return view('personas.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'fecha_nacimiento' => 'required|date',
            'documento_identidad' => 'required|max:255|unique:personas',
            'direccion' => 'required|max:255',
            'telefono' => 'required|max:255',
            'email' => 'required|email|unique:personas',
            'departamento' => 'nullable|string|max:255',
        ]);

        Persona::create($validatedData);

        return redirect()->route('personas.index')
                         ->with('success', 'Persona creada exitosamente.');
    }

    public function show($id)
    {
        $persona = Persona::with('cuentasBancarias')->findOrFail($id);
        return view('personas.show', compact('persona'));
    }

    public function getData($id)
    {
        $persona = Persona::find($id);

        if (!$persona) {
            return response()->json(['error' => 'Persona no encontrada'], 404);
        }

        return response()->json([
            'nombre' => $persona->nombre,
            'email' => $persona->email
        ]);
    }

    public function edit(Persona $persona)
    {
        $departamentos = Departamentos::obtenerLista();
        return view('personas.edit', compact('persona', 'departamentos'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'documento_identidad' => 'required|string|max:255|unique:personas,documento_identidad,' . $id,
            'fecha_nacimiento' => 'required|date|before:today',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:personas,email,' . $id,
            'departamento' => 'nullable|string|max:255',
            // Añade aquí cualquier otro campo que necesites validar
        ]);

        // Buscar la persona por ID
        $persona = Persona::findOrFail($id);

        // Actualizar la persona con los datos validados
        $persona->fill($validatedData);

        // Guardar los cambios en la base de datos
        $persona->save();

        // Redireccionar al index con un mensaje de éxito
        return redirect()->route('personas.index')->with('success', 'Datos de la persona actualizados con éxito.');
    }

    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route('personas.index')->with('success', 'Persona eliminada exitosamente.');
    }
}
