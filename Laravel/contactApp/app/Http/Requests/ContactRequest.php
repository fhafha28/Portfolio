<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Support\Str;


class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        dd($this->route('contact'));
//        route가 사용하고 있는 model 인스턴스나 id를 보여줌

//        dd($this->method());
//        route가 request 보낼 때 어떤 method 쓰는지 보여줌. Post, Put 등등

        return true;
//        ture: meaning that the users are authorized by default
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                'first_name' =>'required|string|max:50',
                'last_name' =>'required|string|max:50',
                'email'=>'required|email',
                'phone'=>'nullable',
                'address'=>'nullable',
                'company_id'=>'required|exists:companies,id'
        ];
    }

    public function attributes(){
        return [
          'company_id'=> 'company',
            'email'=>'e-mail address'
        ];
    }

    public function messages(){
        return [
            'email.email'=>'The e-mail that you entered is not valid',
//            컬럼이름.validation룰이름
            '*.required' =>':attribute cannot be empty'
        ];
    }

//    input data를 서식에 맞게 변형시키기
//    protected function prepareForValidation(){
//        $this->merge([
//            'data'=>$this->date('data')->format('Y-m-d H:i'),
//            'slug'=>$this->title && !$this->slug? Str::slug($this->title) : $this->slug,
//            위에랑 같은데 다른식으로표현한것
//            'slug'=>$this->title && !$this->slug? $this->string('title')->slug()->value : $this->slug,
//
//        ]);
//    }

}
