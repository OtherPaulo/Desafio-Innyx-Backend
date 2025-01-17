<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            ['name' => 'Frutas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Legumes e Verduras', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Carnes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bebidas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laticínios', 'created_at' => now(), 'updated_at' => now()],
        ]);        
    }
}
