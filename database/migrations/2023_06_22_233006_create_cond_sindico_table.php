<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('cond_sindico', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->unsignedInteger('id_condominio');
            $table->unsignedInteger('id_sindico');
            $table->string('turno', 3);

            $table->foreign('id_condominio')->references('id')->on('condominios');
            $table->foreign('id_sindico')->references('id')->on('sindicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('cond_sindico');
    }
};
