<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

// cela tato trieda sa stara len o to ci je bookable avilable.
// skontroluje vstupne data z formularu
// spyta sa databazy na avilability pre dany bookable
// vola sa z Availability.vue
class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from',
        ]);

       $bookable = Bookable::findOrFail($id);
       // toto vrati vsetky bookingy ktore patria nasmu bookable
       //dd($bookable->bookings);
       // toto vytvori query ktore sa da dalej rozvijat s where ....
       //dd($bookable->bookings());


        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json([]) // vratime prazdne pole ak sa to da rezervovat
            : response()->json([], 404) // vratime 404 ak sa neda rezervovat 
        ;
    }
}
