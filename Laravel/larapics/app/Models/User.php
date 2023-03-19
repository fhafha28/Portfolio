<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\Role;
use Illuminate\Support\Facades\Storage;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profile_image',
        'cover_image',
        'city',
        'country',
        'about_me'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role'=>Role::class
    ];

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function social(){
        return $this->hasOne(Social::class)->withDefault();
    }

    public function setting(){
        return $this->hasOne(Setting::class)->withDefault();
    }


    //setting 테이블 populate용. 유저가 생설될 때 booted 써서 setting 자동 생성 되도록
    protected static function booted()
    {
        static::created(function ($user) {
            $user->setting()->create([
                "email_notification" => [
                    "new_comment" => 1,
                    "new_image" => 1
                ]
            ]);
        });
    }


    public function profileImageUrl(){
        return Storage::disk('public')->url($this->profile_image ? $this->profile_image : "user/user-default.png");
    }
//APP_URL=http://localhost:8000
//FILESYSTEM_DISK=public
//src="http://localhost:8000/storage/user/user-default.png"


    public function coverImageUrl(){
        return Storage::url($this->cover_image);
    }

    public function hasCoverImage(){
        return !!$this->cover_image;
//        커버 이미지가 설정 됐냐 안됐냐. 했으면 true 리턴
    }

    public function recentSocial(){
        return $this->hasOne(Social::class)->latestOfMany();
    }

    public function oldestSocial(){
        return $this->hasOne(Social::class)->oldestOfMany();
    }

//    public function socialPriority(){
//        return $this->hasOne(Social::class)->ofMany('priority', 'min');
////    priority컬럼의 값이 가장 낮은걸 반환함. 즉, 우선순위 1인거.
//    }


    public function getImagesCount(){
        $imagesCount = $this->images()->published()->count();
        return $imagesCount.str()->plural(' image', $imagesCount);
    }

//    public function updateSettings($social){
//        Social::updateOrCreate(['user_id' => $this->id], $social);
//        social 모델에서 $this->id와 매치하는 user_id를 찾은 후 있으면 업데이트하고 없으면 생성
//        $social에서 정의된 값을 넣음. social모델의 fillable에 user_id 포함 모든 파트 들어가 있는지 체크


//settingController에서 사용됨
    public function updateSettings($data){
        $this->update($data['user']);
//      컨트롤러에서 request에서 정의한 getData()로 validated된 $data 가져오도록 할거.
//       모든 validated 된 데이터와 함께
//      ['user']라는 어레이 안에 profile_image와 cover_image의 file path가 들어가 있음

        $this->updateSocialProfile($data['social']);
        $this->updateOptions($data['options']);
        // 옵션 변경한거 DB에 업데이트
    }



    public function updateSocialProfile($social){
        Social::updateOrCreate(['user_id' => $this->id], $social);
    }

    public function updateOptions($options){
        $this->setting()->update($options);
    }

//
//        if($this->social()->exists()){
////            유저의 이전 social 기록이 존재하면
//        $this->social()->update($social);
//        }
//        else{
//            $this->social()->create($social);
//        }
////        social 모델안에 fillable 설정 되있는지 체크


// 그림 저장용 디렉토리 만드는 함수. 반드시 static 이어야 함. users라는 폴더 생성
    public static function makeDirectory(){
        $directory = 'users';
        Storage::makeDirectory($directory);
         return $directory;
    }

    public function url(){
        return route('author.show', $this->username);
    }

    public function inlineProfile(){
        return collect([
            $this->name,
            trim(join("/", [$this->city, $this->country]), "/"),
            "Member since ". $this->created_at->toFormattedDateString(),
            $this->getImagesCount()
        ]) ->filter()->implode(" • ");

//  Eding Muhamad • city • country • Member since Oct. 2017 • 40 images


    }
}
