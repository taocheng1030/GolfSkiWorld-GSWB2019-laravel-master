<?php

namespace App\Http\Controllers;

use Youtube;
use App\Http\Requests\TvRequest;
use App\Traits\Additional;
use Illuminate\Http\Request;

class TvController extends Controller
{
    use Additional;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('moderator');

        $this->request = $request;
    }

    public function index()
    {
        return $this->view('view', ['video' => null, 'search' => null, 'channel' => null]);
    }

    public function get(TvRequest $request)
    {
        $video = null;
        if ($request->has('yID')) {
            $video = Youtube::getVideoInfo($request->get('yID'));
        }

        $channel = null;
        if ($request->has('yChannel')) {
            $channel = [
                'info' => Youtube::getChannelById($request->get('yChannel')),
                'playlist' => Youtube::getPlaylistsByChannelId($request->get('yChannel')),
                'search' => Youtube::searchChannelVideos($request->get('ySearch'), $request->get('yChannel'), 40),
            ];
        }

        return $this->view('view', [
            'video' => $video,
            'channel' => $channel,
        ]);
    }

    private function view($blade, $params)
    {
        return view('admin.tv.'.$blade, array_merge([
            'controllerName' => class_basename(get_class($this)),
            'controllerTitle' => 'TV ( YouTube )',
            'controllerUrl' => $this->controllerName()
        ], $params));
    }
}
