@section('header')
<link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/jquery.filer.css') !!}">
<link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css') !!}">
@endsection

<div class="model-movies">

    <div class="model-movies-uploader">
        <div class="filerInput-progress"></div>
        <div class="row">
            <div class="col-sm-12">
                {{ Form::file('files[]', [
                    'id' => 'filerInputVideo',
                    //'multiple' => true,
                    'accept' => config('video.mimeTypes'),
                    'data-token' => csrf_token(),
                    'data-model' => str_plural($model->model),
                    'data-id' => $model->id,
                    'data-url' => adminUrl('videos/upload')
                ]) }}
            </div>
            <div class="col-sm-12 text-center" style="display: none; padding-bottom: 15px;">
                <a class="jFiler-input-choose-btn green filerInput-upload-video">Upload</a>
            </div>
        </div>
    </div>

    <div id="movies-items" class="model-movies-items">
        @foreach($model->videos as $video)
            @include('admin.video.item', ['file' => $video, 'video' => $video->pivot, 'buttons' => ['tags']])
        @endforeach
    </div>

    <div class="clearfix"></div>

</div>

@section('script')
@parent
<script src="{!! asset('vendor/jQuery.filer/js/jquery.filer.js') !!}"></script>
<script src="{!! asset('js/gallery.video.js') !!}"></script>
@endsection