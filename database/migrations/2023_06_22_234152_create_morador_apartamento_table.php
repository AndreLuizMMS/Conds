<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('morador_apartamento', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_apart');
            $table->unsignedInteger('id_morador');

            $table->foreign('id_apart')->references('num_ap')->on('apartamento');
            $table->foreign('id_morador')->references('condx_id')->on('morador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('morador_apartamento');
    }
};
