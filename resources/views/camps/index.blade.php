@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Camps</div>

                    <div class="panel-body">
                        @foreach($camps as $camp)
                            <article>
                                <h4>
                                    <a href="{{ $camp->path() }}">
                                        {{ $camp->name }}
                                    </a>
                                </h4>
                            </article>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
