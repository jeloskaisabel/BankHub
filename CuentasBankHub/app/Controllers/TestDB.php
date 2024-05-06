<?php namespace App\Controllers;

class TestDB extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT * FROM cuentas_bancarias'); // Asegúrate de cambiar 'tu_tabla' por una tabla real en tu DB
        $results = $query->getResult();

        foreach ($results as $row)
        {
            echo $row->id; // Cambia 'tu_columna' por un nombre de columna real en 'tu_tabla'
        }
    }
}
