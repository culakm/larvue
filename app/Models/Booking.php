<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // scope ktory vybere bookings ktore patria do zadaneho timerange
    public function scopeBetweenDates(Builder $query, $from, $to)
    {
        return $query
            ->where('to', '>=', $from)
            ->where('from', '<=', $to);
    }

    // funkcia ma povolene aby vratila Booking alebo null ": ?Booking"
    // vrati Booking ktory ma review_key taky ako sme zadali
    public static function findByReviewKey(string $reviewKey): ?Booking
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }

    protected static function boot()
    {
        parent::boot();
        // $booking je instancia tohto modelu
        static::creating(function ($booking)
        {
            // pri kazdom novom ulozeni booking do tabulky vyplni review_key UUID
            // nezabudnut importovat Illuminate\Support\Str;
            $booking->review_key = Str::uuid();
        });
    }
}
