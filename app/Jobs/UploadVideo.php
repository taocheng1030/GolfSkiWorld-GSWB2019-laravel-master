<?php

namespace App\Jobs;

use App\Domains\Video;
use App\Repositories\FileRepository;
use App\Events\Video\UploadedEvent;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadVideo extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function handle(FileRepository $fileRepository)
    {
        $file = $this->file['name']. '.' . $this->file['ext'];
        $request = $this->file['request'];
        $user = $request['user'];

        error_log(print_r("UploadVideo/Handle - ".$file, TRUE)); 

        error_log(print_r($user, TRUE));

        $video = Video::make($file, $request);
        error_log("UploadVideo/Handle - Attempts : ".$this->attempts()." Max count:".config('video.queue.attempts')); 
        if ($this->attempts() > config('video.queue.attempts') || $video->exception)
        {
            error_log("UploadVideo/Handle - Attempts Exceed: ".$this->attempts()); 
            error_log("UploadVideo/Handle - Exceptiond: ".$video->exception); 
            // try {
            //     $video->clear();
            //     event(new UploadedEvent($user, false));
            // } catch(Exception $e) {

            // }
            $this->delete();
            error_log("UploadVideo/Handle - Job Cancelled "); 
            return false;
        }

        //$video->uploadS3();
        $video->cut()->uploadS3()->thumbnail()->uploadS3($video::THUMB)->clear();

        $model = $fileRepository->create($video->getParams(), $request);

        //insert into video
        $videoData = new \App\Models\Video;
        $videoData->file()->associate($model);
        $videoData->setAttribute('movieable_type', $this->getClassModel($request['model']));
        $videoData->setAttribute('movieable_id', $request['id']);
        $videoData->setAttribute('user_id', $user['id']);
        $videoData->save();
        // $videoData = new \App\Repositories\VideoRepository(new \App\Models\Video, $model);
        // $videoData->create($request, $model);

        event(new UploadedEvent($user, $model));

        error_log("UploadVideo/Handle - Job Completed"); 
    }

    public function getClassModel($model)
    {
        $classes = [      
            \App\User::class,
            \App\Models\Deal::class,
            \App\Models\Lastminute::class,
            \App\Models\Destination::class,
            \App\Models\Accommodation::class,
            \App\Models\Restaurant::class,
            \App\Models\Resort::class,
            \App\Models\Awardinfo::class,
            \App\Models\About::class,
            \App\Models\Destinfo::class,
            \App\Models\Article::class,            
            \App\Models\Site::class
        ];

        $models = array_map(function ($item) {
            $modelName = class_basename($item);
            return str_plural(strtolower($modelName));
        }, $classes);

        if (!in_array($model, $models)) {
            return $this->response->error('Model not specified', 500);
        }

        return $classes[array_search($model, $models)];
    }
}
