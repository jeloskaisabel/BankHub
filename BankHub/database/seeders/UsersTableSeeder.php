<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;  // Importa el modelo User correctamente
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();  // Ahora User está correctamente importado

        $personas = Persona::all();
        if ($personas->isEmpty()) {
            $this->command->info('No hay registros de personas, por favor crea algunos primero!');
            return;
        }

        foreach ($personas as $persona) {
            User::create([
                'username' => $persona->nombre, // Asumiendo que Persona tiene un campo nombre
                'password' => Hash::make('password'), // Contraseña predeterminada
                'persona_id' => $persona->id,
                'rol' => 'user' // Asumiendo que tienes un rol básico
            ]);
        }
    }
}
