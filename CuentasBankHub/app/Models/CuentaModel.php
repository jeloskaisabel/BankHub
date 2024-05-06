<?php namespace App\Models;

use CodeIgniter\Model;

class CuentaModel extends Model
{
    protected $table = 'cuentas_bancarias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['persona_id', 'tipo_cuenta', 'saldo', 'moneda', 'created_at', 'updated_at'];

    public function obtenerCuentasConPersonas()
    {
        return $this->select('cuentas_bancarias.*, personas.nombre, personas.apellido')
                    ->join('personas', 'personas.id = cuentas_bancarias.persona_id')
                    ->orderBy('cuentas_bancarias.id', 'asc')
                    ->findAll();
    }

    public function obtenerTransaccionesPorCuenta($cuentaId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('transacciones');
        return $builder->where('cuenta_bancaria_id', $cuentaId)
                       ->get()
                       ->getResultArray();
    }
    public function eliminarCuenta($id)
    {
        return $this->delete($id);
    }
}
