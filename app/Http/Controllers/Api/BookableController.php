<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function index()
    {
        // vraciame len model
        // return Bookable::all();

        // vraciame data cez resource
        return BookableIndexResource::collection(
            Bookable::all()
        );
    }

    public function show($id)
    {
        // vraciame model so zadanym id
        // return Bookable::findOrFail($id);

        // vraciame len polozky ktore su definovane v resource
        return new BookableShowResource(Bookable::findOrFail($id));
    }
}
