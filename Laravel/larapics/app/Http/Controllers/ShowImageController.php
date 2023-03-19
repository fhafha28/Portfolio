<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Image;

class ShowImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Image $image)
    {
        return view('image-show', compact('image'));
    }
}
