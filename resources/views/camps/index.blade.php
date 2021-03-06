@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumbs>
                    <crumb is-current-page="true">Camps</crumb>
                </breadcrumbs>

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

                    {{-- Camp List --}}
                    <ul class="list-group list-group-flush">
                    @foreach($camps as $camp)
                        <li class="list-group-item d-flex bd-highlight align-items-center">

                            {{-- Left Content --}}
                            <div class="flex-grow-1 bd-highlight">
                                <a href="{{ $camp->path() }}">
                                    {{ $camp->name }}
                                </a>
                            </div>

                            {{-- Right Content --}}
                            <div class="bd-highlight">
                                <form action="{{ $camp->path() }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-link">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                    </ul>

                    {{-- Pagination Links --}}
                    @if($camps->total() > $camps->perPage())
                    <div class="card-footer d-flex justify-content-center pb-0 pt-3">
                        {{ $camps->links() }}
                    </div>
                    @endif

                </div>


            </div>
        </div>
    </div>
@endsection
