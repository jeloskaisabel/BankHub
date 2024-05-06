<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');  // Eliminar el campo 'email'
            $table->renameColumn('name', 'username');  // Cambiar 'name' a 'nombre_usuario'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email');  // Restaurar el campo 'email'
            $table->renameColumn('nombre_usuario', 'name');  // Restaurar el nombre del campo 'name'
        });
    }
};
