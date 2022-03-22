<?php

namespace Database\Seeders;

use App\Models\Bookable;
use Illuminate\Database\Seeder;

class BookablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::factory()->count(13)->create();
    }
}
