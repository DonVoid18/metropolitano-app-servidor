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
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->char('activo', 1)->default('S')->comment("S=si, N=no");
            $table->timestamps();

        });
        $especialidades = [
            ['nombre' => 'Cardiología', 'descripcion' => 'a', 'activo' => 'S'],
            ['nombre' => 'Radiología', 'descripcion' => 'a', 'activo' => 'S'],
            ['nombre' => 'Ginecología', 'descripcion' => 'a', 'activo' => 'S'],
            ['nombre' => 'Pediatría', 'descripcion' => 'a', 'activo' => 'S'],
            // Agrega más especialidades según sea necesario
        ];
        foreach ($especialidades as $especialidad) {
            DB::table('especialidades')->insert($especialidad);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('especialidades');
    }
};
