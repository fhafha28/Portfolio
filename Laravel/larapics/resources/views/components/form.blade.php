@props([
    'action',
    'method' => 'POST'
])
<form action="{{route($action)}}" method="{{strtolower($method)==='get'? 'get': 'post' }}" {{$attributes}}>
    {{--    test.blade.php에서 $action과 $method 값을 물려받아 옴.--}}
    @csrf
    @unless(in_array($method, ['GET', 'POST']))
        @method($method)
    @endunless
    {{$slot}}
</form>
