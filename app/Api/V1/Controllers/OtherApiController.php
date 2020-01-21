<?php

namespace App\Api\V1\Controllers;

use App\Models\DealLimiter;
use App\Models\LastminuteLimiter;
use App\Models\Site;
use App\Models\Language;
use App\Models\AccommodationType;
use App\Models\RestaurantType;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class OtherApiController extends Controller
{
    use Helpers;

    public function relations()
    {
        return [
            'sites' => Site::all(),
            'dealLimiters' => DealLimiter::all(),
            'lastminuteLimiters' => LastminuteLimiter::all(),
            'languages' => Language::all(),
            'accommodationTypes' => AccommodationType::all(),
            'restaurantTypes' => RestaurantType::all()
        ];
    }
}
