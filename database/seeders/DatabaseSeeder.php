<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WriterSeeder::class,
            TranslatorSeeder::class,
            PublisherSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            SpecialIssueSeeder::class,
            MagazineSeeder::class,
            CommentSeeder::class,
            NotificationSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
