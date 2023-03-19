<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable=['disable_comments','moderate_comments','email_notification'];

//    email_notification이 json으로 되어있으므로 이걸 다시 array로 던져야 함
// $casts는 Eloquent 속성값 변환 문법 중 하나. json변수 명(캐스트 되는 속성 이름) => 'array' 하면 array로 바꿔줌.
    protected $casts=[
        'email_notification'=>'array'
    ];

    public function user(){
        $this->belongsTo(User::class);
}


}
