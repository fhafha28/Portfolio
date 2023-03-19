<x-layout title="Discover free images">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col">
                <a href="{{route('images.create')}}" class="btn btn-primary">
                    <x-icon src="upload.svg" alt="Upload" class="me-2" />
                    <span>Upload</span>
                </a>
            </div>
            <div class="col"></div>
            <div class="col text-right">
                <form class="search-form">
                    <input type="search" name="q" placeholder="Search..." aria-label="Search..." autocomplete="off">
                </form>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
<x-flash-message></x-flash-message>
        <div class="row image-grid" data-masonry='{"percentPosition": true }'>
            @foreach($images as $image)
                <div class="col-sm-6 col-lg-4 mb-4">
                    <div class="card">
                        <a href="{{$image->permaLink()}}">
                            <img src="{{$image->fileUrl()}}" alt="{{$image->title}}" height="100%" class="card-img-top">
                            {{--이 $image가 Image 모델에 있는 하나하나의 데이터 값인건 모델에서 이미 정의해놨고 컨트롤러에서 보내줘서 아는 것--}}
                        </a>
                        @canany(['update', 'delete'], $image)
                            <div class="photo-buttons">
                                @can('update',$image)
                                    {{--                <a href="{{route('images.edit', $image->slug)}}">Edit</a>--}}
                                    <a href="{{$image->route('edit')}}" class="btn btn-sm btn-info me-2">Edit</a>
                                @endcan
                                @can('delete', $image)
                                <x-form action="{{$image->route('destroy')}}" method="delete">
                                    <button type="submit" onclick="return confirm('Are you sure?')"
                                            class="btn btn-sm btn-danger">Delete
                                    </button>
                                </x-form>
                                @endcan
                            </div>
                        @endcanany
{{--          이렇게 따로 해놔야 각각의 규칙이 적용되서 Editor는 자기 꺼가 아니면 delete 버튼 안보임--}}


{{--                        @if(Auth::check() && Auth::user()->can('update', $image))--}}
{{--                            <div class="photo-buttons">--}}
{{--                                --}}{{--                <a href="{{route('images.edit', $image->slug)}}">Edit</a>--}}
{{--                                <a href="{{$image->route('edit')}}" class="btn btn-sm btn-info me-2">Edit</a>--}}
{{--                                <x-form action="{{$image->route('destroy')}}" method="delete">--}}
{{--                                    <button type="submit" onclick="return confirm('Are you sure?')"--}}
{{--                                            class="btn btn-sm btn-danger">Delete--}}
{{--                                    </button>--}}
{{--                                </x-form>--}}
{{--                            </div>--}}
{{--                        @endif--}}


                    </div>
                </div>
            @endforeach
        </div>

        {{$images->links()}}

    </div>


</x-layout>
