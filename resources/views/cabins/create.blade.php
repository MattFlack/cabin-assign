@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumbs>
                    <crumb link="/camps">Camps</crumb>
                    <crumb link="{{ $camp->path() }}">{{ $camp->name }}</crumb>
                    <crumb is-current-page="true">Cabins</crumb>
                </breadcrumbs>

                <div class="card mt-4">
                    <div class="card-header">
                        <h2 class="m-0">Add Cabins</h2>
                    </div>

                    <div class="card-body">
                        @include('shared.validation_errors')
                        <form method="POST" action="{{ $camp->path() }}/cabins">
                        @csrf

                        <!--  Cabin Name Input -->
                            <div class="form-group">
                                <label for="name">Cabin Name</label>
                                <input class="form-control" name="name" type="text" id="name" required :autofocus="'autofocus'">
                            </div>

                            <!--  Cabin Capacity Input -->
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input class="form-control" name="capacity" type="number" id="capacity" required>
                            </div>

                            <input class="btn btn-primary" type="submit" value="Submit">

                        </form>
                    </div>
                </div>

                @if(count($camp->cabins) > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="d-flex bd-highlight align-items-center">

                                <!--Left Header-->
                                <div class="flex-grow-1 bd-highlight">
                                    <h2 class="m-0">Cabins</h2>
                                </div>

                                <!-- Right Header -->
                                <div class="bd-highlight">

                                </div>
                            </div>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach($camp->cabins as $cabin)
                                <li class="list-group-item d-flex bd-highlight align-items-center">

                                    <!-- Left Content -->
                                    <div class="flex-grow-1 bd-highlight">
                                        {{ $cabin->name }} sleeps {{ $cabin->capacity }}
                                    </div>

                                    <!-- Right Content -->
                                    <div class="bd-highlight">
                                        {{--<button type="button" class="btn btn-link" @click="deleteCamper(camper, index)">Delete</button>--}}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
