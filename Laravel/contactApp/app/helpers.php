<?php

function sortable($label, $column = null){
    $column = $column?? Str::snake($label);
//    라벨을 snake스타일로 꾸며줌
    $sortBy = request()->query('sort_by');
//    echo($sortBy);  sort_by= 하고 뒤에있는 값 나옴

    $direction = "";
    if(ltrim($sortBy, '-')===$column){
//        -를 제거 했을 때 그게 파라미터로 들어온 column 이름일 경우에만
        $direction = strpos($sortBy,'-')===0?"desc": "asc";
//        -의 포지션이 0이면 desc
    }

    $sortBy = !$sortBy||strpos($sortBy, "-") ===0? $column : "-{$column}";
//   <a href="?sort_by=-first_name"> 저 - 표시가 내림차순이란 뜻
//    sortBy의 값을 column 이름으로 설정
    $url = request()->fullUrlWithQuery(['sort_by'=>$sortBy]);

    return "<a href ='{$url}' class='sortable {$direction}'>$label</a>";
}


function getUndoRoute($name, $resource){
    return request()->missing('undo')? route($name, [$resource->id, 'undo'=> true]):null;

}


//이걸 앱 모든부분에서 접근 가능하게 하려면 composer.json가서 "autoload" 부분 수정해야 함.
//"files":[
//    "app/helpers.php"
//]
//이거 넣어주면 됨.
//이후 터미널에서
//composer dump-autoload
//이거실행
