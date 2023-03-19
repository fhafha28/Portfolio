<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Support\Facades\Storage;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone'=>['nullable', 'string', 'max:255'],
            'company'=>['nullable', 'string', 'max:255'],
            'country'=>['nullable', 'string', 'max:255'],
            'address'=>['nullable', 'string', 'max:255'],
            'profile_picture'=>['nullable', 'image'],
        ])->validate();

        $this->uploadProfilePicture($input);

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        }
//        유저가 이메일을 변경했다면 verification도 해라

        else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'company' => $input['company'],
                'country' => $input['country'],
                'address' => $input['address'],
                'profile_picture' => $input['profile_picture'],
            ])->save();
        }
    }

    protected function uploadProfilePicture(&$input){
//       &$input하면 이 메서드 안에서 변경한 값이 메서드 밖까지 적용됨.

        if (request()->hasFile('profile_picture')){
//            방법1
            $fileName = Storage::putFile('profile', $input['profile_picture']);
//           경로포함 파일명을 return함.

//방법2
            $uploadedFile=$input['profile_picture'];
            $fileName=$uploadedFile->store('profile');
//            default 저장소 말고 다른곳 저장하려면 2nd arg로 적으면 됨. e.g., s3
            $input['profile_picture'] = $fileName;
//
//            dump($uploadedFile->getClientOriginalName());
//            dump($uploadedFile->getClientOriginalExtension());
//            dd($uploadedFile->getClientMimeType());

        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'phone' => $input['phone'],
            'company' => $input['company'],
            'country' => $input['country'],
            'address' => $input['address'],
            'profile_picture' => $input['profile_picture'],
        ])->save();

        $user->sendEmailVerificationNotification();
    }


}
