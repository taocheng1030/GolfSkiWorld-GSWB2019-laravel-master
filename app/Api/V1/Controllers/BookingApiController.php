<?php

namespace App\Api\V1\Controllers;

use App\Events\User\BookedEvent;
use App\Models\Booking;
use App\Repositories\DealRepository;
use App\Repositories\LastminuteRepository;
use App\Traits\Additional;
use App\Traits\Validation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class BookingApiController extends Controller
{
    use Helpers, Additional, Validation;

    public $repositories;

    public function __construct(Request $request, DealRepository $deal, LastminuteRepository $lastminute)
    {
        $this->middleware('jwt.auth');
        $this->request = $request;

        $this->repositories['deal'] = $deal;
        $this->repositories['lastminute'] = $lastminute;
    }

    public function process()
    {
        return $this->handleBooking($this->getModel());
    }

    public function getModel()
    {
        $request = $this->validateCredentials($this->request, [
            'id'      => 'required|numeric',
            'model'   => 'required|string',
        ]);

        if (!array_key_exists($request['model'], $this->repositories)) {
            return $this->response->error('Model not specified', 500);
        }

        $model = $this->repositories[$request['model']]->findPublished($request['id']);
        if (is_null($model))
            return $this->response->error('Model not found', 500);

        return $model;
    }

    public function handleBooking($model)
    {
        $type = get_class($model);

        $booking = Booking::withTrashed()->whereBookableType(get_class($model))->whereBookableId($model->id)->whereUserId($this->user->id)->first();

        if (is_null($booking))
        {
            $booking = Booking::create([
                'user_id'       => $this->user->id,
                'bookable_id'   => $model->id,
                'bookable_type' => $type,
            ]);

            event(new BookedEvent($this->user(), $model));

            return ['status' => $booking->exists];
        }

        return statusFalse(['message' => 'You have already booked this deal']);
    }
}
