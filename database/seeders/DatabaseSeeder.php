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
        $this->call(SupplementLocalisationSeeder::class);
        $this->call(SupplementGabaritSeeder::class);
        $this->call(ServiceSeeder::class);


        // $this->call(RoleSeeder::class);

        $admin = User::create([
            'nom' => 'Jeremie',
            'email' => 'jeremie@alexta.com',
            'role' => 'Administrateur',
            'password' => bcrypt('password'),
        ]);
        // $admin->assignRole('Administrateur');



    }
}
