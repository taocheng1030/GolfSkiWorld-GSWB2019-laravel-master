<?php

namespace App\Console\Commands;

use App\Models\Deal;
use App\Models\Device;
use App\Models\Lastminute;
use Illuminate\Console\Command;
use Davibennun\LaravelPushNotification\Facades\PushNotification;

class BookingReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "All users who made a reservation should get a push notification with reminder about his adventure starts in 'N' days";

    protected $adventures = [
        Deal::class,
        Lastminute::class,
    ];

    protected $types = [
        'IOS' => Device::TYPE_APPLE,
        'Android' => Device::TYPE_ANDROID,
    ];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notifications = collect();
        foreach ($this->adventures as $item)
        {
            $adventures = $item::with('bookings.devices')->has('bookings')
                ->whereRaw('TO_DAYS(`starts`) - TO_DAYS(NOW()) = ?', [config('booking.reminder.time')])
                ->get();

            foreach ($adventures as $adventure) {
                $push['name'] = $adventure->name;
                $push['time'] = $adventure->starts;
                $push['devices'] = [];
                foreach ($adventure->bookings as $user) {
                    foreach ($user->devices as $device) {
                        if ($device->subscribe) {
                            $push['devices'][] = $device->toArray();
                        }
                    }
                }
                $notifications->push($push);
            }
        }

        $this->push($notifications);
    }

    public function push($notifications)
    {
        $responses = collect();
        foreach ($notifications as $notification)
        {
            $message = PushNotification::Message($notification['name'] . ' begin at ' . $notification['time']);

            foreach ($this->types as $device => $type) {
                $devices = $this->getDeviceCollection($notification, $type);
                if (count($devices)) {
                    $devices = PushNotification::DeviceCollection($devices);
                    $responses->push(PushNotification::app($device)->to($devices)->send($message));
                }
            }
        }

        foreach ($responses as $response) {
            foreach ($response->pushManager as $push) {
                $response = $push->getAdapter()->getResponse();
                \Log::info($response);
            }
        }
    }

    public function getDeviceCollection($notification, $deviceType)
    {
        $devices = [];
        foreach ($notification['devices'] as $device)
        {
            if ($device['device_type'] == $deviceType)
                $devices[] = PushNotification::Device($device['device_token']);
        }

        return $devices;
    }
}
