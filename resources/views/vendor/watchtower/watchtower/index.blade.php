@extends(config('watchtower.views.layouts.master'))

@section('wt_content')

    @foreach ( array_chunk($dashboard, 4) as $chunk )
        <div class="row text-center">
        @foreach ($chunk as $item)
            @include( config('watchtower.views.layouts.adminlinks'), [ 'item' => $item ] )
        @endforeach
    </div>
    <!-- /.row -->
    @endforeach

@endsection