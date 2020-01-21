@if( \App\Http\Controllers\Controller::$pagination)
    {{ $models->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
@endif
