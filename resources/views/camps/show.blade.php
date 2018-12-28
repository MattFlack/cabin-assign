@extends('layouts.app')

@section('content')

    <camp :camp="{{ $camp }}"></camp>


    {{--<camp>--}}
        {{--<campers>--}}

        {{--</campers>--}}
    {{--</camp>--}}

    {{--<div class="container">--}}
        {{--<div class="row justify-content-center">--}}
            {{--<div class="col-md-8">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-header">--}}

                        {{--<div class="d-flex bd-highlight align-items-center">--}}

                             {{--Left Header--}}
                            {{--<div class="flex-grow-1 bd-highlight">--}}
                                {{--<h2 class="m-0">{{ $camp->name }}</h2>--}}
                            {{--</div>--}}

                             {{--Right Header--}}
                            {{--<div class="bd-highlight">--}}
                                {{--<a href="{{ $camp->path() }}/campers/create" class="btn btn-secondary btn-sm">--}}
                                    {{--<i class="fas fa-plus"></i>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}

                    {{--<div class="panel-body">--}}
                        {{--<article>--}}
                            {{--<ul class="list-group">--}}
                            {{--@foreach($camp->campers as $camper)--}}
                                {{--<li class="list-group-item">--}}
                                    {{--{{ $camper->name }}--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</article>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection
