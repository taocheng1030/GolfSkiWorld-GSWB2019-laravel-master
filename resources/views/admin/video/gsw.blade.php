@extends('layouts.admin')
@section('title', ':: Users video')
@section('page-header')
    GSW videos
@endsection
@section('breadcrumb')
    <li class="active">GSW videos</li>
@endsection
@section('header')
    <link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/jquery.filer.css') !!}">
    <link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css') !!}">
@endsection
@section('content')

    <div class="box box-default model-movies model-movies-extends">

        <div class="box-header with-border">
            <div class="row">
                <div class="col-xs-8 col-sm-9 col-md-10">
                    <div class="model-movies-uploader">
                        <div class="filerInput-progress"></div>
                        {{ Form::file('files[]', [
                            'id' => 'filerInputVideo',
                            //'multiple' => true,
                            'accept' => config('video.mimeTypes'),
                            'data-token' => csrf_token(),
                            'data-model' => 'users',
                            'data-id' => Auth::getUser()->id,
                            'data-url' => adminUrl('videos/upload'),
                            'data-changeInput' => false
                        ]) }}
                        <div class="text-center" style="display: none;">
                            <a class="jFiler-input-choose-btn green filerInput-upload-video">Upload</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3 col-md-2">
                    <div class="model-trash">
                        <div class="jFiler-input-dragDrop" style="padding-top: 50px;">
                            <div class="jFiler-input-inner">
                                <div class="jFiler-input-icon">
                                    <i class="fa fa-trash"></i>
                                </div>
                                <div class="jFiler-input-text">
                                    <span style="display:block; margin: 10px 0"></span>
                                </div>
                                <a href="{{ adminUrl('videos/trash') }}" class="jFiler-input-choose-btn orange">Trash</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-body">

            <div id="movies-items" class="model-movies-items">
                @foreach($models as $video)
                    @include('admin.video.item', ['file' => $video, 'owner' => $video->owner, 'buttons' => ['tags', 'promo', 'awarded']])
                @endforeach
            </div>

            <div class="clearfix"></div>

        </div>

        <div class="box-footer">
            {!! $models->render() !!}
        </div>

    </div>

@endsection

@section('script')
<script src="{!! asset('vendor/jQuery.filer/js/jquery.filer.js') !!}"></script>
<script src="{!! asset('js/gallery.video.js') !!}"></script>
@endsection