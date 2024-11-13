<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100000)->create();

        $testUser = \App\Models\User::factory()->raw([
            'name' => 'test user',
            'email' => 'test@example.com'
        ]);

        $response = Http::post('http://localhost/api/users', $testUser);
    }
}
