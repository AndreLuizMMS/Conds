<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('morador', function (Blueprint $table) {
            $table->foreign('apartamento')->references('id_apart')->on('morador_apartamento');
        });
        Schema::table('proprietario', function (Blueprint $table) {
            $table->foreign('apartamento')->references('id_apart')->on('prop_apartamento');
        });
        Schema::table('apartamento', function (Blueprint $table) {
            // is set on create_set_keys
            $table->foreign('id_morador')->references('id_morador')->on('morador_apartamento');
            $table->foreign('id_proprietario')->references('id_prop')->on('prop_apartamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('set_keys');
    }
};
