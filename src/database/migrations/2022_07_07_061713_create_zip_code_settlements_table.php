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
        Schema::create('zip_code_settlements', function (Blueprint $table) {
            $table->string('zip_code_key', 5)->index('zip_code_index')->comment('Llave foránea de código postal');
            $table->foreign('zip_code_key', 'zip_code_foreign')->references('zip_code')->on('zip_codes')->onDelete('cascade');
            $table->bigInteger('settlement_key')->index('settlement_index')->unsigned()->comment('Llave foránea de asentamiento');
            $table->foreign('settlement_key', 'settlement_foreign')->references('key')->on('settlements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zip_code_settlements', function (Blueprint $table) {
            $table->dropForeign('zip_code_foreign');
            $table->dropIndex('zip_code_index');
            $table->dropForeign('settlement_foreign');
            $table->dropIndex('settlement_index');
        });
        Schema::dropIfExists('zip_code_settlements');
    }
};
