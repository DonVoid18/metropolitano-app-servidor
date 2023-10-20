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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cod_paciente')->nullable()->references('id')->on('pacientes')->onDelete('restrict');
            $table->foreignId('cod_doctor')->nullable()->references('id')->on('doctores')->onDelete('restrict');
            $table->foreignId('cod_especialidad')->nullable()->references('id')->on('especialidades')->onDelete('restrict');
            $table->string('fecha', 255)->nullable();
            $table->string('hora_inicio', 255)->nullable();
            $table->string('hora_fin', 255)->nullable();
            $table->char('activo', 1)->default('S')->comment("S=si, N=no");
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
        Schema::dropIfExists('citas');
    }
};
