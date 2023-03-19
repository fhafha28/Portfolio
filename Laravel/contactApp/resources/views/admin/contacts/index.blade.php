@extends('layouts.main')
@section('title', 'Contact App | All Contact')
@section('allContacts')
    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-title">
                            <div class="d-flex align-items-center">
                                <h2 class="mb-0">

                                    All Contacts
                                    @if(request()->query('trash'))
                                        <small>(in trash)</small>
                                    @endif
                                </h2>
                                <div class="ml-auto">
                                    <a href="{{route('admin.contacts.create') }}" class="btn btn-success"><i
                                            class="fa fa-plus-circle"></i> Add New</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('shared.filter', ['filterDropdown'=> 'admin.contacts._company-selection'])
                            {{--                            from parent view <br />--}}
                            {{--                            @php var_dump($companies) @endphp--}}
                            @include('shared.flash')

                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">
                                        {!! sortable("First Name", 'first_name') !!}</th>
                                    <th scope="col">{!! sortable("Last Name", 'last_name') !!}</th>
                                    </th>
                                    <th scope="col">Phone</th>
                                    </th>
                                    <th scope="col">{!! sortable("Email") !!}</th>
                                    </th>
                                    <th scope="col">Company</th>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $showTrashBtn = request()->query('trash')?true:false
                                @endphp

                                @forelse($contacts as $index => $contact)
                                    @include('admin.contacts._contacts', ['contact'=>$contact, 'index'=>$index])

                                @empty
                                    @include('shared.empty', ['numCol'=>6, 'message'=>'No contact found'])
                                @endforelse


                                {{--                                 @each('admin.contacts._contacts', $contacts, 'contact', 'admin.contacts._empty')--}}


                                </tbody>
                            </table>

                            {{$contacts->withQueryString()->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <h1>All contacts</h1>
    <br/>
    <a href='{{route('admin.contacts.create') }}'>Add contacts</a>

@endsection

