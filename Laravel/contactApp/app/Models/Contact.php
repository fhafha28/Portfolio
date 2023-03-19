<?php

namespace App\Models;

use App\Models\Scopes\AllowedFilterSearch;
use App\Models\Scopes\AllowedSort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\CompanyFactory;
use Database\Factories\ContactFactory;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\SoftDeletes;




class Contact extends Model
{
//    use HasFactory;
    use HasFactory, SoftDeletes, AllowedFilterSearch, AllowedSort;

//    protected $guarded = [];
    protected $fillable = ['first_name', 'last_name','phone', 'email', 'address', 'company_id'];

    public function company(){
        return $this->belongsTo(Company::class)->withTrashed();
    }

    public function task(){
        return $this->hasMany(Task::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    public function getRouteKeyName(){
//        return '내가 지정했던 유니크한 column_name';
//    }

}

