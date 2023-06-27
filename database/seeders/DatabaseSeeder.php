<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Sindico;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'andreluiz.dev19@gmail.com',
            'password' => bcrypt('asdasd')
        ]);

        // $cond = Condominio::create([
        //     'nome' => 'San Regis'
        // ]);

        // $sind = Sindico::create([
        //     'nome' => 'André'
        // ]);

        // cond_sindico::create([
        //     'id_sindico' => $sind->id,
        //     'id_condominio' => $cond->id,
        //     'turno' => 'mat'
        // ]);
    }
}
