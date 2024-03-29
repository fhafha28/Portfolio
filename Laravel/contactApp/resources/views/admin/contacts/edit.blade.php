@extends('layouts.main')


@section('create')

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-title">
                            <strong>Edit Contact</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.contacts.update', $contact->id)}}" method="POST">
                                @csrf
                                @method('put')
                                @include('admin.contacts._form')</form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('title', 'Contact App | Edit contact')
