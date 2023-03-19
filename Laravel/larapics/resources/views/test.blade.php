<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blade Component</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
   </head>

<body>
@php
$icon = "logo.svg";
$type="info"
@endphp
<x-alert type="info" id="my-alert" class="mt-4" role="flash" >
{{--    <x-slot:title>Success</x-slot:title>--}}
    {{--    <h4 class="alert-heading">{{title}}</h4> 이게 템플릿에 들어있음. 이거 불러온거--}}
    {{$component->icon()}}
{{--    저 icon 함수가 한 view에 2개가 나타나면 먼저 나타난것만 적용되는 듯? --}}
{{--    {{$component->icon(asset('icons/heart.svg'))}}--}}
    <p class="mb-0">Data has been removed. {{$component ->link('Undo')}}</p>
</x-alert>
{{--dismissible="true" 라고 안하고 저렇게만 써도 잘 인식 함. --}}

<x-form action="/images" method="post">
    <input type="text" name="name">
    <button type="submit">Submit</button>
</x-form>


<x-icon :src="$icon"/>
<x-ui.button />




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>


