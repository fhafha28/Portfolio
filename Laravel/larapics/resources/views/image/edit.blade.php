<x-layout title="Update image">



    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">Update Image</div>

                    <div class="card-body">
                        <x-form action="{{$image->route('update')}}" method="put" >
                           <div class="mb-3">
                               <img src = {{$image -> fileUrl() }} alt="{{$image->title}}" class="img-fluid">
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="title">Photo Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" value="{{old('title', $image->title)}}">
                                @error('title')
                                <div class="invalid-feedback"> {{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">
                                        Title is required
                                    </div>
                                    @enderror
                            </div>

                            {{--                            <div class="mb-3">--}}
                            {{--                                <label class="form-label" for="title">Photo Tags</label>--}}
                            {{--                                <input type="text" class="form-control">--}}
                            {{--                                <div class="form-text">--}}
                            {{--                                    Separate your tags with comma--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{route('images.index')}}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </x-form>


                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layout>
