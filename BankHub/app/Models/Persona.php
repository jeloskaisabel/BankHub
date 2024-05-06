<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 'apellido', 'fecha_nacimiento', 'documento_identidad',
        'direccion', 'telefono', 'email', 'departamento',
    ];
    protected $dates = ['fecha_nacimiento'];


    public function cuentasBancarias() {
    return $this->hasMany(CuentaBancaria::class);
}
}
