@if (count($errors))
    <div class="alert alert-danger" role="alert">
        <ul class="list-unstyled m-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif