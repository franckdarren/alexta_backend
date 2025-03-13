<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('name');
            //les clefs etrangers
            $table->foreignId('service_id')->nullable()->constained('services')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constained('users')->onDelete('cascade');

            //les clefs etrangers des supplements
            $table->foreignId('supplement_gabarit_id')->nullable()->constained('supplement_gabarits')->onDelete('cascade');
            $table->foreignId('supplement_localisation_id')->nullable()->constained('supplement_localisations')->onDelete('cascade');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
