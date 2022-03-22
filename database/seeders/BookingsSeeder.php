<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pre kazdy bookable z DB bezim funkciu
        Bookable::all()->each(
            function (Bookable $bookable) {
                // vytvorim booking
                $booking = Booking::factory()->make();
                // vytvorim collection bookingov
                $bookings = collect([$booking]);
                // vytvaram nahodny pocet bookingov
                for ($i = 0; $i < random_int(1, 20); $i++){

                    $from = (clone($booking->to)->addDays(random_int(1, 14)));
                    $to = (clone($from)->addDays(random_int(0, 14)));
                    // pridam from a to do bookingu
                    $booking = Booking::make([
                        'from' => $from,
                        'to' => $to
                    ]);
                    // pridam booking do collection
                    $bookings->push($booking);
                }
                // ulozim do DB collection bookingov
                $bookable->bookings()->saveMany($bookings);
            }
        );
    }
}
