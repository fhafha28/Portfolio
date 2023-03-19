<?php

namespace App\Http\Controllers;


use App\Http\Requests\UpdateSettingRequest;
use App\Models\User;


class SettingController extends Controller
{

    /**
     * Handle the incoming request.
     */


    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function edit(){
        return view("setting", [
            'user'=> auth()->user()
        ]);
    }

    public function update(UpdateSettingRequest $request){
//        dd($request->getData());
        $request->user()->updateSettings($request->getData());
//UpdateSettingRequest에서 만든 메서드 저렇게 화살표 써서 불러와서 쓸 수 있게된거.
//updateSetting은 user모델에서 정의했고 getData()는 UpdateSettingRequest에서 정의했음.
//users 테이블의 데이터를 바꾸는거니까 저 updateSettings()의 정의는 user 모델 안에 되있어야 함
        //getData로 validated된 모든 data 가져온걸 updateSettings에서 싹 업데이트 하는거
        return back()->with('message', "Your changes have been saved");
//        return view("setting", [
//            'user'=> auth()->user()
//        ]);
    }

}
