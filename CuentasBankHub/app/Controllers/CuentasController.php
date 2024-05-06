<?php namespace App\Controllers;

use App\Models\CuentaModel;

class CuentasController extends BaseController
{
    public function index()
    {
        $model = new CuentaModel();
        $cuentas = $model->obtenerCuentasConPersonas();
        $data['cuentas'] = [];

        foreach ($cuentas as $cuenta) {
            $cuenta['transacciones'] = $model->obtenerTransaccionesPorCuenta($cuenta['id']);
            $data['cuentas'][] = $cuenta;
        }

        echo view('lista_cuentas', $data);
    }

    public function eliminar($id)
    {
        $model = new CuentaModel();
        $model->eliminarCuenta($id);
        return redirect()->to('/cuentas');  // Asegúrate de que esta es la URL correcta
    }
}
