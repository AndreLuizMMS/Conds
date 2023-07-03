<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apartamento;
use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Condxmino;
use App\Models\Proprietario;
use App\Models\Sindico;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        // Proprietario::create([
        //     'condx_id' => 1,
        //     'apartamento' => 6,
        //     'condominio' => 1
        // ]);
    }
}
