<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_documento', 12)->nullable();
            $table->string('nombres', 60)->nullable();
            $table->string('apellidos', 60)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('sexo', 60)->nullable();
            $table->string('password', 60)->nullable();
            $table->string('estado_civil', 60)->nullable();
            $table->string('direccion', 60)->nullable();
            $table->string('fecha_nacimiento', 60)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('grupo_sangre', 60)->nullable();
            $table->string('email', 60)->nullable();
            $table->char('activo', 1)->default('S')->comment("S=si, N=no");
            $table->date('fecha_retiro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
};
