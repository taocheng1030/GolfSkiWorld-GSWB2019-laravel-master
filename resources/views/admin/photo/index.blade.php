@extends('layouts.admin')
@section('title', ':: Users photo')
@section('page-header')
    Users photo
@endsection
@section('breadcrumb')
    <li class="active">Users photo</li>
@endsection
@section('header')
    <link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/jquery.filer.css') !!}">
    <link rel="stylesheet" href="{!! asset('vendor/jQuery.filer/css/themes/jquery.filer-dragdropbox-theme.css') !!}">
@endsection
@section('content')

    <div class="box box-default model-gallery model-movies-extends">

        <div class="box-body">

            <div id="movies-items" class="model-movies-items">
                @foreach($models as $photo)
                    @include('admin.photo.item', ['file' => $photo, 'owner' => $photo->owner, 'withoutButtons' => true])
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
<script src="{!! asset('js/gallery.photo.js') !!}"></script>
@endsection