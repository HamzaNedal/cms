<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  
        Page::factory()->create();
    }
}
