<?php

namespace App\Http\Controllers;

use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Rap2hpoutre\LaravelLogViewer\LaravelLogViewer;

class LogsController extends LogViewerController
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

        parent::__construct();
    }

    public function index()
    {
        if ($this->request->has('l')) {
            LaravelLogViewer::setFile(
                base64_decode($this->request->get('l'))
            );
        }

        if ($this->request->has('dl')) {
            return response()->download(
                LaravelLogViewer::pathToLogFile(
                    base64_decode($this->request->get('dl'))
                )
            );
        }

        if ($this->request->has('del')) {
            \File::delete(
                LaravelLogViewer::pathToLogFile(
                    base64_decode($this->request->get('del')))
            );
            return redirect($this->request->url());
        }

        $logs = LaravelLogViewer::all();

        return view('vendor.logviewer.log', [
            'logs' => $logs,
            'files' => LaravelLogViewer::getFiles(true),
            'current_file' => LaravelLogViewer::getFileName()
        ]);
    }
}
