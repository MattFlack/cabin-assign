@extends('layouts.app')

@section('content')

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card mb-5">
                    <div class="card-header">
                        <h2>{{ $camper->name }}</h2>
                        <span class="badge badge-secondary">Friends: {{ $camper->friends->count() }}</span>
                    </div>

                    <ul class="list-group list-group-flush">

                        @foreach($camper->friends as $friend)
                            <li class="list-group-item">{{ $friend->friendOfCamper->name }}</li>
                        @endforeach

                    </ul>
                </div>

                @include('shared.validation_errors')
                <h2>Add Friends</h2>
                <add-friend-form :friends="{{ $camper->friends }}" end-point="{{ $camper->path() }}" :camper="{{ $camper }}" :campers="{{ $camper->camp->campers }}"></add-friend-form>

            </div>
        </div>
    </div>

@endsection