@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Session::has('success'))

    <div class="alert alert-success" style='z-index: 1000;'>
        <ul>
            <li>{{ Session::get('success')}}</li>
        </ul>
    </div>

@endif

@if(Session::has('Error'))

    <div class="alert alert-danger" style='z-index: 1000;'>
        <ul>
            <li>{{ Session::get('Error')}}</li>
        </ul>
    </div>

@endif
