@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumbs>
                    <crumb link="/camps">Camps</crumb>
                    <crumb link="{{ $camper->camp->path() }}">{{ $camper->camp->name }}</crumb>
                    <crumb is-current-page="true">{{ $camper->name }}</crumb>
                </breadcrumbs>

                <h2 class="mt-4 mb-3">{{ $camper->name }}</h2>

                @include('shared.validation_errors')

                <div class="card">
                    <div class="card-header">
                        <h3>Add Friends</h3>
                    </div>
                    <div class="card-body">

                        <add-friend-form
                                :friends="{{ $camper->friends }}"
                                end-point="{{ $camper->path() }}"
                                :camper="{{ $camper }}"
                                :campers="{{ $camper->camp->campers }}">
                        </add-friend-form>
                    </div>
                </div>

                <div class="card mb-5 mt-3">

                    <div class="card-header">
                        <div class="d-flex bd-highlight align-items-center">

                            {{-- Left Header --}}
                            <div class="flex-grow-1 bd-highlight">
                                <h3>Friends</h3>
                            </div>

                            {{-- Right Header --}}
                            <div class="bd-highlight">
                                <span title="Total Friends" class="badge badge-secondary">Total: {{ $camper->friends_count }}</span>
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



            </div>
        </div>
    </div>

@endsection

