<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Medardo Pantoja',
            'email' => 'medardo.pantoja@escueladeartes1.edu.ar',
            'password' => bcrypt('12345678'),
            'rol' => 'Admin',
            'id_preceptor' => null,
            'id_administrativo' => null,
            'id_docente' => null,
        ]);
    }
}
