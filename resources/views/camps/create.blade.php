@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Create a New Camp</h2>

                @include('shared.validation_errors')

                <form method="POST" action="/camps">
                    @csrf

                    <!-- Camp.vue Name Form Input -->
                    <div class="form-group">
                        <label for="name">Camp Name</label>
                        <input class="form-control" name="name" type="text" id="name" required :autofocus="'autofocus'">
                    </div>

                    <input class="btn btn-primary" type="submit" value="Submit">

                </form>

            </div>
        </div>
    </div>
@endsection
