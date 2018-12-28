@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex bd-highlight align-items-center">

                        {{-- Left Header --}}
                        <div class="flex-grow-1 bd-highlight">
                            <h2 class="m-0">Camps</h2>
                        </div>

                        {{-- Right Header --}}
                        <div class="bd-highlight">
                            <a href="/camps/create" class="btn btn-secondary btn-sm" title="Create New Camp">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <ul class="list-group">
                        @foreach($camps as $camp)
                            <li class="list-group-item">
                                <a href="{{ $camp->path() }}">
                                    {{ $camp->name }}
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
