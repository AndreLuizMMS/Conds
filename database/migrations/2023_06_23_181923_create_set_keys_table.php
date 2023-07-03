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
            $table->foreign('apartamento_id')->references('id')->on('apartamento');
        });

        Schema::table('proprietario', function (Blueprint $table) {
            $table->foreign('apartamento_id')->references('id')->on('apartamento');
            $table->foreign('condominio')->references('condominio')->on('apartamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('set_keys');
    }
};
