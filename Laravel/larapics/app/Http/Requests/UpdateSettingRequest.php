<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        //        ture: meaning that the users are authorized by default
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'social.*' => 'nullable|url',
            'options/disable_comments' => 'boolean',
            'options.moderate_comments' => 'boolean',
            'options.email_notification.*' => 'nullable',
//이거 이름이 setting.어쩌구 가 아닌 이유는 blade파일에서 input 받아올 때 name속성이
//            name="options[disable_comments]"이런식으로 options 어쩌구로 되어있기 때문

            'user.username' => 'required|max:30|unique:users,username,' . auth()->id(),
//            .auth()->id() 안붙이면 사용자 이름 열이 아닌 다른 열만 변경하는 경우에도 이 조건이 충족됐나고 나옴.
            'user.name' => 'required|string',
            'user.profile_image' => 'nullable|image',
            'user.cover_image' => 'nullable|image',
            'user.city' => 'nullable|string',
            'user.country' => 'nullable|string',
            'user.about_me' => 'nullable|string',

            //            'account.email'=>'required|email|unique:users,email,' 아래와 같이 쓸 수도 있음.  ignore 파트 뺴고 똑같은 소리
            'account.email' => ['required', 'email', Rule::unique('users', 'email')->ignore(auth()->id())],
            'account.password' => [
                Rule::requiredIf(
                    $this->account['email'] !== auth()->user()->email || !empty($this->account['new_password']),
                    //블레이드에서 account[email]파트에 입련한 게 유저테이블에 저장된 email이 아니거나 (새 이메일 주소 입력),
                    // 새 비밀번호를 입력한 경우
                    function ($attribute, $value, $fail) {
                        if (!empty($value) && Hash::check($value, auth()->user()->password())) {
//                           value(새 비밀번호)에 입력값이 있고, 현재 비밀번호와 새 비밀번호 비교해서 같으면 true
                            $fail("The password is incorrect");
//                            위 조건이 true가 나오면 error 메세지를 날려라
                        }
                    }
                )],

            'account.new_password' => 'confirmed'
//           confirmed는 "주어진 이름_confirmation" 필드의 input이 해당 값과 같은지 확인.
        ];
    }

    public function attributes()
    {
        return [
            'social.facebook' => 'facebook',
            'social.twitter' => 'twitter',
            'social.instagram' => 'instagram',
            'social.website' => 'website',
            'user.username' => 'username',
            'user.name' => 'name',
            'user.profile_image' => 'profile_image',
            'user.cover_image' => 'cover_image',
            'user.city' => 'city',
            'user.country' => 'country',
            'user.about_me' => 'about_me',
            'account.email' => 'email',
            'account.password' => 'current password',
            'account.new_password' => 'new password'
            //원래는 웹페이지에 에러메세지 뜰 때 The social.facebook field must be a valid URL. 이렇게 뜨는데
            //이렇게 attributes를 해놓으면 그냥 The facebook field ... 이렇게 뜸.
        ];

    }

    //rules에 따라서 validation 한 후에 이 함수들 발생됨.
    public function getData()
    {
        $data = $this->validated();

        User::makeDirectory();
        $directory = User::makeDirectory(); //user라는 데렉터리 생성
        $directory = $directory . "/user-" . auth()->id(); // users/user-1

        if ($this->hasFile('user.profile_image')) {
            $data['user']['profile_image'] = $this->file('user.profile_image')->store($directory);
        }

        if ($this->hasFile('user.cover_image')) {
            $data['user']['cover_image'] = $this->file('user.cover_image')->store($directory);
        }
//        블레이드에서 불러오는 데이터가 $data[어쩌구]들. name속성에 저장된 값.  name="user[cover_image]"

        if (!empty($data['account']['password'])) {
            $data['user']['email'] = $data['account']['email'];
        }

        if (!empty($data['account']['new_password'])) {
            $data['user']['password'] = Hash::make($data['account']['new_password']);
//            비밀번호 안에 새로운 비밀번호 값 넣기. Hash 넣어서 암호화
        }

        unset($data['account']);
//      data array에서 account 제거. 기존 비밀번호, email 저장된 곳이 account 였으니까.
//      새 비밀번호와 새 email을 $data['user'] 안에 저장한 이후에는
//      $data['account']에 있는 데이터들은 쓸모 없어지니까 삭제하는 것.

        return $data;
    }

}
