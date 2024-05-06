<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Persona; 
use Illuminate\Support\Arr;

class AssignDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departamentos = ['La Paz', 'Santa Cruz', 'Cochabamba', 'Oruro', 'Potosí', 'Tarija', 'Chuquisaca', 'Beni', 'Pando'];

        Persona::all()->each(function ($persona) use ($departamentos) {
            $persona->update(['departamento' => Arr::random($departamentos)]);
        });
    }
}
