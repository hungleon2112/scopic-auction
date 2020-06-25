@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show text-left mt-2" role="alert">
        <ul style="margin: 0; padding-left: 10px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('message'))
    <div class="alert alert-success alert-dismissible fade show text-left mt-2" role="alert">
        <ul style="margin: 0; padding-left: 10px">
            <li>{{ session('message') }}</li>
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
