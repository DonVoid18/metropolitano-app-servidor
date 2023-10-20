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
        Schema::create('doctores', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100)->nullable();
            $table->string('apellidos', 255)->nullable();
            $table->foreignId('cod_especialidad')->nullable()->references('id')->on('especialidades')->onDelete('restrict');
            $table->char('sexo', 1)->nullable();
            $table->char('char', 9)->nullable();
            $table->char('correo',50)->nullable();
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
        Schema::dropIfExists('doctores');
    }
};
