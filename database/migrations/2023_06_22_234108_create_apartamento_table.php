<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('apartamento', function (Blueprint $table) {
            $table->integer('num_ap')->primary();
            $table->unsignedInteger('condominio');
            $table->unsignedInteger('id_morador')->nullable();
            $table->unsignedInteger('id_proprietario')->nullable();

            $table->foreign('condominio')->references('id')->on('condominios');

            // is set on create_set_keys
            // $table->foreign('id_morador')->references('id_morador')->on('morador_apartamento');
            // $table->foreign('id_proprietario')->references('id_prop')->on('prop_apartamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('apartamento');
    }
};
