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
            $table->increments('id')->unique();
            $table->integer('num_ap');
            $table->unsignedInteger('condominio');
            $table->timestamps();


            $table->foreign('condominio')->references('id')->on('condominios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('apartamento');
    }
};
