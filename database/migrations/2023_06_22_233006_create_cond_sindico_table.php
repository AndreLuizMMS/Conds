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
            $table->increments('id');
            $table->unsignedInteger('id_condomino');
            $table->unsignedInteger('id_sindico');
            $table->string('turno', 3);

            $table->foreign('id_condomino')->references('id')->on('condominios');
            $table->foreign('id_sindico')->references('id')->on('sindicos');
        });

        DB::statement("ALTER TABLE cond_sindico ADD CONSTRAINT turno_trab CHECK('turno' IN ('mat', 'ves', 'not') )");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('cond_sindico');
    }
};
