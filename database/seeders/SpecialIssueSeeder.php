<?php

namespace Database\Seeders;

use App\Models\SpecialIssue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SpecialIssue::factory(25)->create();
    }
}
