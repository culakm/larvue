<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id){
        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|size:36|unique:reviews', // kontrola pre uuid
            'content' => 'required|min:3',
            'rating' => 'required|in:1,2,3,4,5' // rating moze byt len cislo od 1 do 5
        ]);

        // existuje zaznam pre booking?
        $booking = Booking::findByReviewKey($data['id']);

        if($booking === null) {
            return abort(404);
        }

        // booking sa nasiel, pretoze ma fake uuid, vynulujeme to a ulozime
        $booking->review_key = '';
        $booking->save();

        // vytvorime novu instanciu review s pouzitim uz validovanych dat
        $review = Review::make($data);
        // pridame do nej rucne booking_id aby to neslo cez fillable
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();
        return new ReviewResource($review); 
    }
}
