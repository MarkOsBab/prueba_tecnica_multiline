<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) { 
            DB::table(env('CLIENT_TABLE_NAME'))->insert([
                'cliente_nombre' => fake()->company(),
                'cliente_correo' => fake()->companyEmail(),
            ]);
        }
    }
}
