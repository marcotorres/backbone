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
        Schema::create('federal_entities', function (Blueprint $table) {
            $table->id('key')->comment('Clave Entidad (INEGI, Marzo 2013)');
            $table->string('name', 100)->comment('Nombre Entidad (INEGI, Marzo 2013)');
            $table->string('code', 100)->nullable(true)->comment('Campo Vacio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('federal_entities');
    }
};
