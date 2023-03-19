@extends('layouts.main')
@section('title', 'Contact App | All Companies')
@section('content')
    {{--    이 섹션이름은 반드시 content여야 함. 안그럼 화면 아예 안뜸--}}
    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-title">
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">

                                    All Companies
                                    @if(request()->query('trash'))
                                        <small>(in trash)</small>
                                    @endif
                                </h2>
                                <div class="ml-auto">
                                    <a href="{{route('companies.create') }}" class="btn btn-success"><i
                                            class="fa fa-plus-circle"></i> Add New</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('shared.filter')

                            @include('shared.flash')

                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {!! sortable("Name", 'name') !!}</th>
                                    <th scope="col">address</th>
                                    </th>
                                    <th scope="col">{!! sortable("Website") !!}</th>
                                    </th>
                                    <th scope="col">{!! sortable("Email") !!}</th>
                                    </th>
                                    <th scope="col">Contacts</th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $showTrashBtn = request()->query('trash')?true:false
                                @endphp

                                @forelse($companies as $index => $company)
                                    @include('companies._company', ['company'=>$company, 'index'=>$index])
                                @empty
                                    @include('shared.empty', ['numCol'=>6, 'message'=>'No company found'])
                                @endforelse
                                {{--                                 @each('companies._company', 'companies', 'company', 'companies._empty')--}}

                                </tbody>
                            </table>

                            {{$companies->withQueryString()->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <h1>All contacts</h1>
    <br/>
    <a href='{{route('companies.create') }}'>Add contacts</a>

@endsection

