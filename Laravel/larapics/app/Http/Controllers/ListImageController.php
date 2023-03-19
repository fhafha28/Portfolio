<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListImageController extends Controller
{

    /**
     *
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $images = Image::published()->latest()->paginate(15)
            ->withQueryString();
        //published는 Image모델에서 내가 local scope로 정의한 static 함수임
        //withQueryString() 페이지 넘어가도 쿼리 스트링은 그대로 유지하게 해줌
        return view('image-list', compact('images'));
    }
}
