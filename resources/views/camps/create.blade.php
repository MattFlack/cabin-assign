@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Add Camp</h2>

                @include('shared.validation_errors')

                {!! Form::open(['url' => '/camps']) !!}

                    <!-- Camp Name Form Input -->
                    <div class="form-group">
                        {{ Form::label('name', 'Camp Name') }}
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                     </div>

                    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
