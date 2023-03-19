<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests\ImageRequest;

class ImageController extends Controller
{
    public function __construct(){

//        여기 있는 모든 method를 로그인 한 유저에게만 허락되게 하기. 자동으로 login 페이지로 redirect
        $this->middleware(['auth']);

        $this->authorizeResource(Image::class, 'image');
//  2번째 arg는 route 파라미터. 근데 모델이름의 소문자 형이면 굳이 안써줘도 라라벨이 알아서 인식.
//이렇게 해두면 라라벨에서 지정한 default 폴리시를 따라감
    }
    public function index(){

//        admin으로 로그인한 유저를 위해 발행자가 아니어도 이미지를 볼 수 있도록 하기
//        visibleFor은 Image모델에서 로컬 scope로 정의한거
        $images = Image::visibleFor(request()->user())
            ->latest()->paginate(15)->withQueryString();

//        로그인한 유저가 자기가 발행한 그림만 볼 수 있도록하기
//        $images = request()->user()->images()
//                ->published()->latest()->paginate(15)->withQueryStirng();

//        $images = Image::published()->latest()->paginate(15)
//        ->withQueryString();
        //published는 Image모델에서 내가 local scope로 정의한 static 함수임
        //withQueryString() 페이지 넘어가도 쿼리 스트링은 그대로 유지하게 해줌
        return view('image.index', compact('images'));
    }

//    public function show(Image $image){
//        return view('image.show', compact('image'));
//        // get요청 할 때 blade 파일에서 이미 하나의 이미지를 특정해서 보내놨음. 그거 Image $image로 받아온거
//    }

    public function create(){
        return view('image.create');
   }


    public function store(ImageRequest $request)
    {
        Image::create($request->getData());
//create() 속성 배열을 수락하고 모델을 생성한 다음 데이터베이스에 삽입합니다
        return redirect()->route('images.index')->with('message', "Image has been uploaded successfully");
   }


    public function edit(Image $image){
//        if(request()->user()->id !== $image->user_id ){
//            abort(403, "Access denied.");
//        }
//        if(!Gate::allows('update-image', $image)){
//            abort(403, "Access denied");
//        }
//        $user는 안넣어도 Laravel이 알아서 포함시킴. update-image는 내가 Gate만들 때 작명한 거

// Gate 혹은 Policy 방법1 사용한 경우
//        Gate::authorize('update-image', $image);
//         혹은
//        $this->authorize('update-image',$image);

//Policy 방법 2. $policies 이용한 경우 혹은 Conventional 한 네이밍 해서 만든 경우
//        $this->authorize('update',$image);
//                             AuthServiceProvider에서 작명한 거

//로그인 했는데 update 권한이 없으면 Edit 페이지 넘어가는거 못하게 해라
//        if(request()->user()->cannot('update', $image)){
//            abort(403, "Access denied");
//        }


        return view('image.edit', compact('image'));
        // 여기도 get요청 할 때 blade 파일에서 이미 하나의 이미지를 특정해서 보내놨음. 그거 Image $image로 받아온거
    }

    public function update(Image $image, ImageRequest $request)
    {
//        $this->authorize('update',$image);
        $image->update($request->getData());
        return to_route('images.index')->with('message', "Image has been updated successfully");
    }

    public function destroy(Image $image)
    {
//        $this->authorize('delete',$image);

//        if(Gate::denies('delete-image', $image)){
//            abort(403, "Access denied");
//        }
        $image->delete();
        return to_route('images.index')->with('message', "Image has been removed successfully");
    }

}


