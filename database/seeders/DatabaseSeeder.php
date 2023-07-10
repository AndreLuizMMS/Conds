<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apartamento;
use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Condxmino;
use App\Models\Sindico;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {

        \App\Models\User::factory()->create([
            'name' => 'André',
            'email' => 'sindico@test.com',
            'password' => bcrypt('asdasd'),
            'isAdmin' => 0,
            'isSindico' => 1
        ]);
        \App\Models\User::factory()->create([
            'name' => 'admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('asdasd'),
            'isAdmin' => 1,
            'isSindico' => 0
        ]);

        $cond = Condominio::create([
            'nome' => 'San Regis'
        ]);
        for ($i = 0; $i < 10; $i++) {
            Apartamento::create([
                'num_ap' => $i + 100,
                'condominio' => $cond->id
            ]);
        }
        $sind = Sindico::create([
            'nome' => 'André'
        ]);
        cond_sindico::create([
            'id_sindico' => $sind->id,
            'id_condominio' => $cond->id,
            'turno' => 'mat'
        ]);


        $condx = Condxmino::create([
            'nome' => 'André Luiz'
        ]);

        $cond2 = Condominio::create([
            'nome' => 'Metropolitan'
        ]);
        for ($i = 0; $i < 10; $i++) {
            Apartamento::create([
                'num_ap' => $i + 100,
                'condominio' => $cond2->id
            ]);
        }

        $cond3 = Condominio::create([
            'nome' => 'BrookFiled'
        ]);
        for ($i = 0; $i < 10; $i++) {
            Apartamento::create([
                'num_ap' => $i + 100,
                'condominio' => $cond3->id
            ]);
        }

        $cond4 = Condominio::create([
            'nome' => 'Praia Grande'
        ]);
        for ($i = 0; $i < 10; $i++) {
            Apartamento::create([
                'num_ap' => $i + 100,
                'condominio' => $cond4->id
            ]);
        }
    }
}
