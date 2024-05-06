<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// En la parte superior de CuentaBancariaController.php
use App\Models\CuentaBancaria;
use App\Models\Persona;
// ... resto del archivo ...


class CuentaBancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
// app/Http/Controllers/CuentaBancariaController.php
public function index(Request $request)
{
    $query = CuentaBancaria::with('persona');

    if ($request->filled('tipo_cuenta')) {
        $query->where('tipo_cuenta', $request->tipo_cuenta);
    }

    $cuentas = $query->paginate(10); // Pagina los resultados, 10 cuentas por página
    $tiposDeCuenta = CuentaBancaria::select('tipo_cuenta')->distinct()->pluck('tipo_cuenta');

    return view('cuentas_bancarias.index', compact('cuentas', 'tiposDeCuenta'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $personas = Persona::all();
        return view('cuentas_bancarias.create', compact('personas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'persona_id' => 'required|exists:personas,id',
        'tipo_cuenta' => 'required|in:corriente,ahorro,inversión', // Asegúrate de que los tipos de cuenta son válidos
        'saldo' => 'required|numeric|min:0', // El saldo debe ser numérico y no negativo
        'moneda' => 'required|in:USD,EUR,BOB', // Lista de códigos de monedas permitidas
        // Añade aquí otras validaciones que necesites
    ]);

    $cuenta = CuentaBancaria::create($validated);

    return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria creada con éxito.');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cuenta = CuentaBancaria::with('persona')->findOrFail($id); // Asegúrate de cargar la relación con Persona
        return view('cuentas_bancarias.show', compact('cuenta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cuenta = CuentaBancaria::findOrFail($id); // Encuentra la cuenta o falla si no existe
        $tiposDeCuenta = ['corriente', 'ahorro', 'inversión']; // O obtén estos datos de una fuente configurada
        return view('cuentas_bancarias.edit', compact('cuenta', 'tiposDeCuenta'));
    }

    public function update(Request $request, $id)
    {
        $cuenta = CuentaBancaria::findOrFail($id);

        $validatedData = $request->validate([
            'tipo_cuenta' => 'required|in:corriente,ahorro,inversión',
            'saldo' => 'required|numeric|min:0',
            'moneda' => 'required|string|max:3', // Asume que las monedas son de tres letras como USD, EUR, etc.
        ]);

        $cuenta->update($validatedData);

        return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CuentaBancaria $cuentaBancaria)
    {
        $cuentaBancaria->delete();
        return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria eliminada con éxito.');
    }
}
