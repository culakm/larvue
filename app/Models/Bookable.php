<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookable extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // vracia bool, false ak nasiel nejaky booking (vtedy uz je zarezervovane)
    public function availableFor($from, $to): bool
    {
        // vrati bookingy v tomto timerange
       return 0 === $this->bookings()->betweenDates($from, $to)->count();
    }
}
