@section('header')
<link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/jquery.filer.css') !!}">
<link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css') !!}">
@endsection

<div class="model-gallery">

    <div class="model-gallery-uploader">
        <div class="filerInput-progress"></div>
        <div class="row">
            <div class="col-sm-12">
                {{ Form::file('files[]', [
                    'id' => 'filerInputPhoto',
                    'multiple' => true,
                    'accept' =>  config('photo.mimeTypes'),
                    'data-token' => csrf_token(),
                    'data-model' => str_plural($model->model),
                    'data-id' => $model->id,
                    'data-url' => adminUrl('photos/upload')
                ]) }}
            </div>
            <div class="col-sm-12 text-center" style="display: none; padding-bottom: 15px;">
                <a class="jFiler-input-choose-btn green filerInput-upload-photo">Upload</a>
            </div>
        </div>
    </div>

    <div id="gallery-items" class="model-gallery-items">
        @foreach($photos as $photo)
            @if ($photo->imageable_id == $model->id)
                @include('admin.photo.item', ['file' => $photo->file, 'isThumbnail' => $photo->thumbnail])
            @endif
        @endforeach
    </div>

    <div class="clearfix"></div>

</div>

@section('script')
@parent
<script src="{!! asset('vendor/jQuery.filer/js/jquery.filer.js') !!}"></script>
<script src="{!! asset('js/gallery.photo.js') !!}"></script>
@endsection