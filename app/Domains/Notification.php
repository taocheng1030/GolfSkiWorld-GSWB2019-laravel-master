<?php

namespace App\Domains;

class Notification
{
    private $client;
    private $devices;
    private $messages;

    private function __construct($client)
    {
        $app = \App::make('aws');
        switch ($client) {
            case 'mail' :
                $this->messages = [
                    'success' => "Email notification sent",
                    'failed'  => "Email notification failed"
                ];
                break;

            case 'push' :
                $this->client = $app->createClient('sns');
                $this->messages = [
                    'success' => "Push notification sent",
                    'failed'  => "Push notification failed"
                ];
                break;

            case 'sms' :
                $this->client = $app->createClient('sms');
                $this->messages = [
                    'success' => "SMS notification sent",
                    'failed'  => "SMS notification failed"
                ];
                break;
        }
    }

    public function devices($model)
    {
        return $this;
    }

    public function publish()
    {
        // ToDo:: make send notification here

        return $this->messages['success'];
    }

    public static function make($client)
    {
        return new self($client);
    }
}