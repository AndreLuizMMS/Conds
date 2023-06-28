<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Apartamento;
use App\Models\cond_sindico;
use App\Models\Condominio;
use App\Models\Condxmino;
use App\Models\Morador;
use App\Models\morador_apartamento;
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

        $cond = Condominio::create([
            'nome' => 'San Regis'
        ]);
        $sind = Sindico::create([
            'nome' => 'André'
        ]);
        cond_sindico::create([
            'id_sindico' => $sind->id,
            'id_condominio' => $cond->id,
            'turno' => 'mat'
        ]);



        $condxMorador = Condxmino::create([
            'nome' => 'André Luiz'
        ]);
        $condxMorador2 = Condxmino::create([
            'nome' => 'Deds'
        ]);

        // $ap = Apartamento::create([
        //     'num_ap' => 1504,
        //     'condominio' => $cond->id,
        // ]);

        // 10x for loop
        for ($i = 1; $i < 10; $i++) {
            Apartamento::create([
                'num_ap' => $i,
                'condominio' => $cond->id,
            ]);
        }

        // Morador::create([
        //     'condx_id' => $condxMorador->id,
        //     'apartamento' => $ap->num_ap,
        //     'condominio' => $cond->id
        // ]);
        // Morador::create([
        //     'condx_id' => $condxMorador2->id,
        //     'apartamento' => $ap->num_ap,
        //     'condominio' => $cond->id
        // ]);
    }
}
