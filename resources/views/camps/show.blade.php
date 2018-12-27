@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                        <div class="d-flex bd-highlight">
                            <div class="flex-grow-1 bd-highlight">
                                {{ $camp->name }}
                            </div>

                            <div class="bd-highlight">
                                <a href="{{ $camp->path() }}/campers/create" class="btn btn-link btn-sm">Add Camper</a>
                                <button class="btn btn-link btn-sm">Edit</button>
                            </div>
                        </div>

                    </div>

                    <div class="panel-body">
                        <article>
                            <ul class="list-group">
                            @foreach($camp->campers as $camper)
                                <li class="list-group-item">
                                    {{ $camper->name }}
                                </li>
                            @endforeach
                            </ul>
                        </article>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
