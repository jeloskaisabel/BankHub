<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaccion;
use App\Models\CuentaBancaria;

class TransaccionController extends Controller
{
    
    public function index()
    {
        $transacciones = Transaccion::paginate(10); // Paginar con 10 elementos por página
        return view('transacciones.index', compact('transacciones'));
    }

    public function create()
    {
        $cuentasBancarias = CuentaBancaria::pluck('id', 'id'); // Obtener una lista de todos los IDs de cuentas bancarias
        return view('transacciones.create', compact('cuentasBancarias'));
    }

    public function store(Request $request)
    {
        // Valida los datos del formulario
        $request->validate([
            'cuenta_bancaria_id' => 'required',
            'tipo_transaccion' => 'required',
            'monto' => 'required',
            'fecha_transaccion' => 'required',
        ]);

        // Crea una nueva transacción en la base de datos
        Transaccion::create($request->all());

        // Redirige al usuario a la página de inicio o a donde prefieras
        return redirect()->route('transacciones.index')->with('success', 'Transacción creada exitosamente.');
    }

    public function show(Transaccion $transaccion)
    {
        // Retorna la vista que muestra los detalles de una transacción específica
        return view('transacciones.show', compact('transaccion'));
    }

    public function edit(Transaccion $transaccion)
    {
        $cuentasBancarias = CuentaBancaria::pluck('id', 'id'); // Obtener una lista de todos los IDs de cuentas bancarias
        return view('transacciones.edit', compact('transaccion', 'cuentasBancarias'));
    }

    public function update(Request $request, Transaccion $transaccion)
{
    // Valida los datos del formulario
    $request->validate([
        'cuenta_bancaria_id' => 'required',
        'tipo_transaccion' => 'required',
        'monto' => 'required',
        'fecha_transaccion' => 'required',
    ]);

    // Actualiza la transacción en la base de datos
    $transaccion->update([
        'cuenta_bancaria_id' => $request->cuenta_bancaria_id,
        'tipo_transaccion' => $request->tipo_transaccion,
        'monto' => $request->monto,
        'fecha_transaccion' => $request->fecha_transaccion,
    ]);

    // Redirige al usuario a la página de inicio o a donde prefieras
    return redirect()->route('transacciones.index')->with('success', 'Transacción actualizada exitosamente.');
}

    public function destroy(Transaccion $transaccion)
    {
        // Elimina la transacción de la base de datos
        $transaccion->delete();

        // Redirige al usuario a la página de inicio o a donde prefieras
        return redirect()->route('transacciones.index')->with('success', 'Transacción eliminada exitosamente.');
    }
}
