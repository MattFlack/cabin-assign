@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumbs>
                    <crumb link="/camps">Camps</crumb>
                    <crumb is-current-page="true">New Camp</crumb>
                </breadcrumbs>

                <div class="card">
                    <div class="card-header">
                        <h2 class="m-0">Create a New Camp</h2>
                    </div>

                    <div class="card-body">
                        @include('shared.validation_errors')
                        <form method="POST" action="/camps">
                            @csrf

                            <!-- Camp Name Input -->
                            <div class="form-group">
                                <label for="name">Camp Name</label>
                                <input class="form-control" name="name" type="text" id="name" required :autofocus="'autofocus'">
                            </div>

                            <input class="btn btn-primary" type="submit" value="Submit">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
