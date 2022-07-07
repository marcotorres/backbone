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
        Schema::create('zip_codes', function (Blueprint $table) {
            $table->string('zip_code', 5)->primary()->comment('Código Postal asentamiento');
            $table->string('locality', 100)->comment('Nombre Ciudad (Catálogo SEPOMEX)');
            $table->bigInteger('federal_entity_key')->index('federal_entity_index')->unsigned()->comment('Llave foránea de la entidad');
            $table->foreign('federal_entity_key', 'federal_entity_foreign')->references('key')->on('federal_entities')->onDelete('cascade');
            $table->bigInteger('municipality_key')->index('municipality_index')->unsigned()->comment('Llave foránea de la municipalidad');
            $table->foreign('municipality_key', 'municipality_foreign')->references('key')->on('municipalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zip_codes', function (Blueprint $table) {
            $table->dropForeign('federal_entity_foreign');
            $table->dropIndex('federal_entity_index');
            $table->dropForeign('municipality_foreign');
            $table->dropIndex('municipality_index');
        });
        Schema::dropIfExists('zip_codes');
    }
};
