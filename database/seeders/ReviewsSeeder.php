<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable) {
            // $reviews = factory(Review::class, random_int(5, 30))->make();
            $reviews = Review::factory()->count(random_int(5, 30))->make();
            $bookable->reviews()->saveMany($reviews);
        });
    }
}