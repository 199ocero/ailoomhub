<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $provider = \App\Models\AiProvider::factory()->create([
            'name' => 'OpenAI',
        ]);

        \App\Models\AiModel::factory()->create([
            'ai_provider_id' => $provider->id,
            'name' => 'gpt-3.5-turbo',
        ]);

        \App\Models\KnowledgeBase::factory()->create([
            'name' => 'Notion',
        ]);
    }
}
