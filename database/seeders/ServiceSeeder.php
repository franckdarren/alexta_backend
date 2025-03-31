<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Insertion dans la BDD

        Service::create([
            'nom' => 'Lavage',
            'description' => "Lavage complet des véhicules",
            'prix_base' => 5000,
        ]);
    }
}