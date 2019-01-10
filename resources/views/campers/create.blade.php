@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumbs>
                    <crumb link="/camps">Camps</crumb>
                    <crumb link="{{ $camp->path() }}">{{ $camp->name }}</crumb>
                    <crumb is-current-page="true">Campers</crumb>
                </breadcrumbs>

                <div class="card">
                    <div class="card-header">
                        <h3 class="m-0">Add Campers</h3>
                    </div>

                    <div class="card-body">

                        @include('shared.validation_errors')
                        <form method="POST" action="{{ $camp->path() . '/campers' }}">
                        @csrf

                        <!--  Camper Name Input -->
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" name="name" type="text" id="name" required :autofocus="'autofocus'">
                            </div>

                            <input class="btn btn-primary" type="submit" value="Submit">

                        </form>
                    </div>
                </div>


                @if(count($camp->campers) > 0)
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="d-flex bd-highlight align-items-center">

                                <!--Left Header-->
                                <div class="flex-grow-1 bd-highlight">
                                    <h2 class="m-0">Campers</h2>
                                </div>

                                <!-- Right Header -->
                                <div class="bd-highlight">
                                    <span title="Total Campers" class="badge badge-secondary">Total: {{ $camp->campers_count }}</span>
                                </div>

                            </div>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach($camp->campers as $camper)
                                <li class="list-group-item d-flex bd-highlight align-items-center">

                                    <!-- Left Content -->
                                    <div class="flex-grow-1 bd-highlight">
                                        {{ $camper->name }}
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
