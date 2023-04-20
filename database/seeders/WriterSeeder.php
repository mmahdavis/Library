<?php

namespace Database\Seeders;

use App\Models\Writer;
use Database\Factories\WriterFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Writer::factory(5)->create();
    }
}
