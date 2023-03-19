<?php

namespace App\Models\Scopes;
use Illuminate\Database\Eloquent\Builder;

trait AllowedSort
{

    Public function parseSortDirection($column=null){
        return strpos($column?? request()->query('sort_by'), "-")===0 ? 'desc' : 'asc';
    }

    public function parseSortColumn($column = null){
        return ltrim($column ?? request()->query('sort_by'),"-");
//        -뒤에 오는 실제 컬럼 명
    }
    Public function scopeAllowedSorts(builder $query, array $columns, $defaultColumn=null){
        $column = $this->parseSortColumn();
        if(in_array($column, $columns)){
            return $query->orderBy($column, $this -> parseSortDirection());
        //     컬럼에 따라 오름차순 정렬. 어떤 컬럼 따라갈지는 컨트롤러에서 결정.
        }
        if (!$column && $defaultColumn){
            return $query->orderBy($this->parseSortColumn($defaultColumn), $this -> parseSortDirection($defaultColumn));
        }
        return $query;
    }
}

