@extends('layouts.app')

@section('content')

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ $camper->camp->path() }}">Back to Camp</a>

                <div class="card mb-5 mt-3">

                    <div class="card-header">
                        <div class="d-flex bd-highlight align-items-center">

                            {{-- Left Header --}}
                            <div class="flex-grow-1 bd-highlight">
                                <h2>{{ $camper->name }}</h2>
                            </div>

                            {{-- Right Header --}}
                            <div class="bd-highlight">
                                <span class="badge badge-secondary">Friends: {{ $camper->friends->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <ul class="list-group list-group-flush">

                        @foreach($camper->friends as $friendship)
                            <li class="list-group-item d-flex bd-highlight align-items-center">

                                {{-- Left Content --}}
                                <div class="flex-grow-1 bd-highlight">
                                    {{ $friendship->friendOfCamper->name }}
                                </div>

                                {{-- Right Content --}}
                                <div class="bd-highlight">
                                    <form action="{{ $friendship->path() }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-link">Delete</button>
                                    </form>
                                </div>

                            </li>
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

