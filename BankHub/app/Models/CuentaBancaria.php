<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    use HasFactory;
    protected $table = 'cuentas_bancarias';
    protected $fillable = [
        'persona_id', 'tipo_cuenta', 'saldo', 'moneda'
    ];

    public function persona() {
        return $this->belongsTo(Persona::class);
    }
    
    public function transacciones() {
        return $this->hasMany(Transaccion::class);
    }
}
