<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('morador', function (Blueprint $table) {
            $table->unsignedInteger('condx_id');
            $table->integer('apartamento');
            $table->unsignedInteger('condominio');
            $table->timestamps();


            $table->foreign('condx_id')->references('id')->on('condxminos');
            $table->foreign('condominio')->references('id')->on('condominios');

            // is set on create_set_keys
            // $table->foreign('apartamento')->references('id_apart')->on('morador_apartamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('morador');
    }
};
