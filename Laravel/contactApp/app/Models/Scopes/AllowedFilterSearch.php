<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;

trait AllowedFilterSearch
{
    Public function scopeForUser(Builder $query, User $user){
//        return $query->where('user_id', $user->id);
        return $query->whereBelongsTo($user);
    }

    Public function scopeAllowedFilter(Builder $query, ...$keys ){
        foreach($keys as $index=>$key){
            if ($value=request()->query($key)){
                $query->where($key, $value);
            }
//            Company Id에 따라 sort한다고 하면 value는 companyID가 되고 keys는 company ID들로 된 어레이?
        }
        return $query;
//        쿼리에 따라 검색 수행. 어떤 쿼리 따라갈지는 컨트롤러에서 결정
    }

    Public function scopeAllowedSearch(Builder $query, ...$keys){
//        $keys로는 어떤 컬럼을 검색할지 컬럼 이름을 array형식으로 집어넣을 것임.
//        dd($keys);
        if($search=request()->query('search')){
            foreach($keys as $index => $key){
                $method=$index === 0 ? 'where' : 'orWhere';
                $query->{$method}($key, "LIKE", "%{$search}%");
            }
        }
        return $query;
    }

    public function scopeAllowedTrash(Builder $query){
        if(request()->query('trash')){
            $query->onlyTrashed();
        }
        return $query;
    }

}

