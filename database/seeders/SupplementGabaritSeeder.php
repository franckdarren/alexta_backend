<?php

namespace Database\Seeders;

use App\Models\SupplementGabarit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplementGabaritSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Insertion dans la BDD

        SupplementGabarit::create([
            'type' => 'Petit',
            'montant' => 5000,
        ]);

        SupplementGabarit::create([
            'type' => 'Grand',
            'montant' => 10000,
        ]);
    }
}