<?php

namespace Database\Seeders;

use App\Models\Condominio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Condominios extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Condominio::create([
            'nome' => 'test'
        ]);
    }
}
