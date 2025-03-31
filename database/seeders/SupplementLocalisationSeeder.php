<?php

namespace Database\Seeders;

use App\Models\SupplementLocalisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplementLocalisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Insertion dans la BDD

        SupplementLocalisation::create([
            'lieu' => 'Akanda',
            'montant' => 5000,
        ]);

        SupplementLocalisation::create([
            'lieu' => 'Libreville',
            'montant' => 5000,
        ]);

        SupplementLocalisation::create([
            'lieu' => 'Owendo',
            'montant' => 5000,
        ]);
    }
}