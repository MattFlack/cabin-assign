@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $camp->name }}
                        <button class="btn btn-link btn-sm float-right">Edit</button>
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
