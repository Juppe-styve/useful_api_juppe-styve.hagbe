<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('modules')->insert([
            ['id' => 1, 'name' => 'URL Shortener', 'description' => 'Raccourcir et gérer des liens'],
            ['id' => 2, 'name' => 'Wallet', 'description' => 'Gestion du solde et transferts'],
            ['id' => 3, 'name' => 'Marketplace', 'description' => 'Gestion de produits et commandes'],
            ['id' => 4, 'name' => 'Time Tracker', 'description' => 'Suivi du temps et sessions'],
            ['id' => 5, 'name' => 'Investment Tracker', 'description' => 'Suivi du portefeuille d’investissement'],
        ]);
    }
}