<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Image;


class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        if($this->method()=='PUT'){
            return [ 'title'=>'required'];
        }
        return [
            'file'=>'required|image',
            'title'=>'nullable'
        ];
    }

//    유효성 검사, storage에 저장, 필수 컬럼값 지정을 한번에 하는 function임. 이걸 컨트롤러에 보내서 DB에 저장할거임.
//이미지는 DB에 저장되는게 아니라 storage에 저장되는거. DB에는 이미지가 어느 Storage에 저장됐는지 등등의 정보가 저장됨.
    public function getData(){
        $data = $this->validated() + [
            'user_id'=>$this->user()->id
            ];
//        어레이 앞에 + 붙인거는 푸시한단뜻. 즉, validate한 $data 어레이에 user_id를 푸시해라

        if ($this->hasFile('file')){
            $directory = Image::makeDirectory();
//            이미지 모델에서 현재 날짜로 storage에 폴더 만들라고 함수 정의해둔거
            $data['file'] = $this->file->store($directory);
//            현재날짜로 폴더 만들어서 파일 저장하고 그 값은 컬럼 $data['file']에 저장.
//              이 컬럼값은 파일의 저장경로 넣어두기로 했었으니까.
            $data['dimension'] = Image::getDimension($data['file']);
        }


        return $data;
    }

    //중복검사 후 중복시 이름에 숫자 넣기
    protected function getSlug($title)
    {
        $slug = str($title)->slug();
        $numSlugFound = Image::where('slug','regexp', "^".$slug."(-[0-9])?")->count();
//        이름, 숫자 포함 이름 있는거 다 찾아서 개수 세기
        if ($numSlugFound>0){
            return $slug."-".$numSlugFound+1;
        } else { return $slug; }
    }


}
