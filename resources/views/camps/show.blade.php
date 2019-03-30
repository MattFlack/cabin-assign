@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <breadcrumbs>
                    <crumb link="/camps">Camps</crumb>
                    <crumb is-current-page="true">{{ $camp->name }}</crumb>
                </breadcrumbs>

                <div class="card">

                    <div class="card-header">
                        <h2 class="m-0">{{ $camp->name }}</h2>
                    </div>

                    <div class="card-body">
                        <tabs>

                            <tab name="Campers" :selected="true">
                                @if(count($camp->campers) > 0)
                                    <campers :campers="{{ $camp->campers }}"></campers>
                                @else
                                    <div class="mt-4 alert alert-info text-center col-md-4 offset-4" role="alert">
                                        <p>You have none!</p>
                                        <a class="btn btn-outline-info btn-sm" href="{{ $camp->path() . '/campers/create' }}">Add Campers</a>
                                    </div>
                                @endif
                            </tab>

                            <tab name="Cabins">
                                @if(count($camp->cabins) > 0)
                                    <cabins :cabins="{{ $camp->cabins }}"></cabins>
                                @else
                                    <div class="mt-4 alert alert-info text-center col-md-4 offset-4" role="alert">
                                        <p>You have none!</p>
                                        <a class="btn btn-outline-info btn-sm" href="{{ $camp->path() . '/cabins/create' }}">Add Cabins</a>
                                    </div>
                                @endif
                            </tab>

                            <tab name="Assign Cabins">
                                <assign-cabins
                                    :camp="{{ $camp }}"
                                    :camp-id="{{ $camp->id }}">
                                </assign-cabins>
                            </tab>

                            <tab name="Add New" :is-dropdown="true">
                                <tab-dropdown-item name="Camper" dropdown-link="{{ $camp->path() . '/campers/create' }}"></tab-dropdown-item>
                                <tab-dropdown-item name="Cabin" dropdown-link="{{ $camp->path(). '/cabins/create' }}"></tab-dropdown-item>
                            </tab>

                        </tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
