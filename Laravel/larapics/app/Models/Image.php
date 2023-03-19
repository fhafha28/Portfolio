<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\Role;

class Image extends Model
{
    use HasFactory;
    protected $fillable=['title', 'file', 'dimension', 'user_id', 'slug'] ;

    public static function makeDirectory(){
        $subFolder='images/'.date('y/m/d');
        Storage::makeDirectory($subFolder);
        return $subFolder;
    }

    public static function getDimension($image){
        [$width, $height] =  getimagesize(Storage::path($image));
//       destructuring 문법
        return $width."x".$height;
    }


    public function scopePublished(Builder $query){
        return $query->where('is_published', true);
//         엘로퀸트 sql 쿼리를 사용해서 해당 컬럼이 true인 데이터만 리턴해라
    }

    public function scopeVisibleFor($query, User $user){
        if($user->role===Role::Admin||$user->role===Role::Editor){
            return;
            //Admin이나 Editor인경우 코드 여기서 끝내고 아니면 다음 쿼리로 넘어가서 user_id에 제약걸기
        }
        $query->where("user_id", $user->id);
    }

    public function fileUrl(){
        return Storage::disk('local')->url($this->file);
//        $this->file은 file컬럼의 값을 뜻함. 내가 get할 파일이 이 파일이란건 이 function을 통해 인식함.
    }

    public function permalink(){
        return route('images.show', $this->slug );
        //    web.php의 show 요청 할 때 url이 images/show/{$image} 이렇게 되는데
        // 이 때 slug가 저기에 들어가게 한건 여기서 설정해 둔거. url지정과 관련되는 부분임.
    }

    public function route($method, $key='id'){
        return route("images.{$method}", $this->$key);
    }

    //중복검사 후 중복시 이름에 숫자 넣기
    public function getSlug()
    {
        $slug = str($this->title)->slug();
        $numSlugFound = static::where('slug','regexp', "^".$slug."(-[0-9])?")->count();
//        이름, 숫자 포함 이름 있는거 다 찾아서 개수 세기
//        static:: 이건 현재 Image 모델에 있으니까 Image::를 뜻함
        if ($numSlugFound>0){
            return $slug."-".$numSlugFound+1;
        } else { return $slug; }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function uploadDate(){
        return $this->created_at->diffForHumans();
    }


//다양한 모델 이벤트가 발송될 때 실행되는 booted라는 함수를 등록할거임
//새 모델이 저장될 때 Eloquent에서는 자동으로 creating이란걸 실행함. 그리고 생성 완료되면 created를 실행함.
//마찬가지로 updating, updated도 있음
//여기서  부분에대가 slug 이름은 기존 slug 이름을 가져온다고 조건 붙여서
//slug값이 불변하게 만드는 것.
    protected static function booted(){
        static::creating(function($image){
            if($image->title){
                $image->slug= $image->getSlug(); //타이틀을 slug로 써라
                $image->is_published=true;
            }
        });

        static::updating(function($image){
            if($image->title && !$image->slug){
                $image->slug= $image->getSlug();
                $image->is_published=true;
            }
//            slug값이 없을 때만 slug 값을 타이틀 값으로 해서 업데이트 해라
        });

        static::deleted(function($image){
            Storage::delete($image->file);
        });
//DB에서 이미 삭제된 후지만 받아온 instance가 있어서 deleted로 해도 정상작동 하는 듯.
    }

}
