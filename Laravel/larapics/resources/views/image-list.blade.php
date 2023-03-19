<x-layout title="Discover free images">

    <div class="container-fluid mt-4">
        @if($message = session('message'))
            <x-alert type="success" dismissible>
                {{$component->icon()}}
                {{$message}}
            </x-alert>
        @endif
        <div class="row image-grid" data-masonry='{"percentPosition": true }'>
            @foreach($images as $image)
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card">
                        <a href="{{$image->permaLink()}}">
                            <img src="{{$image->fileUrl()}}" alt="{{$image->title}}" height="100%" class="card-img-top">
                            {{--이 $image가 Image 모델에 있는 하나하나의 데이터 값인건 모델에서 이미 정의해놨고 컨트롤러에서 보내줘서 아는 것--}}
                        </a>


                    </div>
                </div>
            @endforeach
        </div>

        {{$images->links()}}

    </div>


</x-layout>
