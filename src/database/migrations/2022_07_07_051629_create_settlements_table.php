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
        Schema::create('settlements', function (Blueprint $table) {
            $table->bigInteger('key')->unsigned()->comment('Identificador único del asentamiento (nivel municipal)');
            $table->string('name', 100)->comment('Nombre asentamiento');
            $table->string('zone_type', 100)->comment('Zona en la que se ubica el asentamiento (Urbano/Rural)');
            $table->bigInteger('settlement_type_key')->index('settlement_type_index')->unsigned()->comment('Llave foránea del tipo de asentamiento');
            $table->foreign('settlement_type_key', 'settlement_type_foreign')->references('key')->on('settlement_types')->onDelete('cascade');
            $table->string('zip_code_key', 5)->index('zip_code_index')->comment('Llave foránea de código postal');
            $table->foreign('zip_code_key', 'zip_code_foreign')->references('zip_code')->on('zip_codes')->onDelete('cascade');
            $table->primary(['key', 'zip_code_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlements', function (Blueprint $table) {
            $table->dropForeign('settlement_type_foreign');
            $table->dropIndex('settlement_type_index');
            $table->dropForeign('zip_code_foreign');
            $table->dropIndex('zip_code_index');
        });
        Schema::dropIfExists('settlements');
    }
};
