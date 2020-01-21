@extends('layouts.admin')
@section('title', ':: Users video')
@section('page-header')
    Trash for users video
@endsection
@section('breadcrumb')
    <li class="active">Trash for users video</li>
@endsection
@section('content')

    <div class="box box-default model-movies model-movies-extends">

        <div class="box-header with-border">
            <a href="{{ adminUrl('videos/users')}}" class="btn btn-default">
                <i class="fa fa-fa-long-arrow-left"></i>
                Back to users video
            </a>
        </div>

        <div class="box-body">

            <div id="file-items" class="model-file-items">
                @foreach($models as $video)
                    @include('admin.video.trash.item', ['file' => $video, 'owner' => $video->owner])
                @endforeach
            </div>

            <div class="clearfix"></div>

        </div>

        <div class="box-footer">
            {!! $models->render() !!}
        </div>

    </div>

@endsection
