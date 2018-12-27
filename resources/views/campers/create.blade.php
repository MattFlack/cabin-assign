@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Add Campers</h2>

                @include('shared.validation_errors')

                <form method="POST" action="{{ $camp->path() }}/campers" >
                    @csrf

                    <!-- Camper Name Form Input -->
                    <div class="form-group">
                        <label for="name">Camper Name</label>
                        <input class="form-control" name="name" type="text" id="name" :autofocus="'autofocus'" required>
                    </div>

                    <input class="btn btn-primary" type="submit" value="Submit">

                </form>

            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="list-group">
                @foreach($camp->campers as $camper)
                    <li class="list-group-item">{{ $camper->name }}</li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection