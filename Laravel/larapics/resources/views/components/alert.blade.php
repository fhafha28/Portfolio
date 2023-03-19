<div {{$attributes->merge(['class'=>$getClasses,'role'=>$attributes->prepends('alert')]
   )}}>
{{--    getClasses = 'alert'--}}
{{--      'role'=>'alert',   이렇게만 하면 default값이 alert가 됨.--}}
{{--     default값 유지한 채 추가적으로 속성에 값 넣고 싶을 때.--}}

    @isset($title)
        <h4 class="alert-heading">{{$title}}</h4>
    @endisset
{{--최종 blade에서 title값을 안준경우 페이지 로드 자체가 안되고 에러뜨기때문에 그걸 방지하기 위해--}}

    {{$slot}}
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

{{--원래 부트스트랩 모양--}}
{{--<div class="alert alert-warning alert-dismissible fade show" role="alert">--}}
{{--    <strong>Holy guacamole!</strong>--}}
{{--    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
{{--</div>--}}

{{--<table>--}}
{{--    <thead>--}}
{{--    <tr></tr>--}}
{{--    </thead>--}}
{{--    <tbody>--}}
{{--    <tr></tr>--}}
{{--    </tbody>--}}
{{--</table>--}}
