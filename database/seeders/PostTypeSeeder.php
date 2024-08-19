<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostType;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        PostType::updateOrCreate(['type_name' => 'text']);
        PostType::updateOrCreate(['type_name' => 'image']);
        PostType::updateOrCreate(['type_name' => 'video']);
    }
}
