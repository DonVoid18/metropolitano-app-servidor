<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->char('activo', 1)->default('S')->comment("S=si, N=no");
           
            $table->timestamps();
        });
        
        DB::table('roles')->insert([
            [
                'nombre' => 'Administrador',
                'tipo' => 'Admin',
                'activo' => 'S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Cliente',
                'tipo' => 'Cliente',
                'activo' => 'S',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más inserciones según sea necesario
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
