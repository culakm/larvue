<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $bookable = Bookable::findOrFail($id);
        // vratime reviews daneho bookable zoradene podla datumu a to prezenieme resources aby sme dostali len stlpce ktore chceme
        return BookableReviewIndexResource::collection($bookable->reviews()->latest()->get());
    }
}
