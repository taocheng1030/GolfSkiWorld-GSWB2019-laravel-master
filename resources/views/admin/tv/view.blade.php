@extends('layouts.admin')
@section('title', ':: ' . $controllerTitle)
@section('page-header')
    {{ $controllerTitle }}
@endsection
@section('breadcrumb')
    <li class="active">{{ $controllerTitle }}</li>
@endsection
@section('content')

@php
    $yID = (Request::has('yID') && !Request::has('ySearch')) ? Request::input('yID') : null;
    $yChannel = Request::has('yChannel') ? Request::input('yChannel') : null;
    $ySearch = Request::has('ySearch') ? Request::input('ySearch') : null;
@endphp

    <div class="box model-movies model-movies-youtube">
        <div class="box-header with-border">

            {{ Form::open([
                'action' => $controllerName.'@get',
                'role' => 'form',
                'class' => 'form-inline no-margin'
            ]) }}

            <div class="form-group">
                {{ Form::text('yID', $yID, ['class' => 'form-control', 'placeholder' => 'ID']) }}
            </div>

            &nbsp;

            <div class="form-group">
                {{ Form::text('yChannel', $yChannel, ['class' => 'form-control', 'placeholder' => 'Channel ID']) }}
            </div>

            &nbsp;

            <div class="form-group">
                {{ Form::text('ySearch', $ySearch, ['class' => 'form-control', 'placeholder' => 'Search in channel']) }}
            </div>

            {!! Form::button('Show', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}

            {{ Form::close() }}

        </div>

        <div class="box-body">

            @if($video)
                <div style="float: left; margin-right: 10px">
                    {!! $video->player->embedHtml !!}
                </div>
                <div style="float: right; width: calc(100% - 500px)">
                    {{--{{ dump($video) }}--}}
                </div>
                <div class="clearfix"></div>
            @endif

            @if($channel && $channel['info'])

                <div class="model-movies-items" id="movies-items">
                    @foreach($channel['search'] as $item)
                    @php
                        $yID = $yID ? '&yID='.$yID : null;
                        $yChannel = $yChannel ? '&yChannel='.$yChannel : null;
                        $ySearch = $ySearch ? '&ySearch='.$ySearch : null;

                        $channelUrl = adminUrl('tv/get?yChannel='.$item->snippet->channelId . $yID . $ySearch);
                        $videoUrl = adminUrl('tv/get?yID='.$item->id->videoId . $yChannel . $ySearch);
                    @endphp

                        <div class="model-movies-item">
                            <div class="model-movies-item-image">
                                {!! HTML::image($item->snippet->thumbnails->medium->url) !!}
                            </div>
                            <div class="caption">
                                <div class="name">{{ $item->snippet->title }}</div>
                                <div class="email"><a href="{{ $channelUrl }}">{{ $item->snippet->channelTitle }}</a></div>
                                <p> </p>
                            </div>
                            <div class="buttons">
                                <a href="{{ $videoUrl }}" class="btn btn-default" role="button">View</a>
                            </div>
                        </div>

                    @endforeach
                </div>

                <div class="clearfix"></div>

                {{--{{ dump($channel) }}--}}

            @endif

        </div>

    </div>

@endsection
