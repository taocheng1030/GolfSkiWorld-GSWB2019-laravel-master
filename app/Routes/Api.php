<?php

use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function (Router $api) {
    // Auth
    $api->group(['prefix' => 'auth'], function (Router $api) {
        // Login/Logout
        $api->post('login', 'App\Api\V1\Controllers\Auth\AuthController@login');
        $api->post('logout', 'App\Api\V1\Controllers\Auth\AuthController@logout');

        // Register
        $api->post('signup', 'App\Api\V1\Controllers\Auth\AuthController@signUp');

        // Oauth
        $api->post('facebook/login', 'App\Api\V1\Controllers\Auth\AuthController@facebookLogin');

        // User
        $api->get('user', 'App\Api\V1\Controllers\Auth\AuthController@show');
        $api->post('update', 'App\Api\V1\Controllers\Auth\AuthController@update');
        $api->post('recovery', 'App\Api\V1\Controllers\Auth\AuthController@recovery');
    });

    $api->group(['prefix' => 'device'], function (Router $api) {
        $api->get('/', 'App\Api\V1\Controllers\DeviceApiController@index');
        $api->post('/', 'App\Api\V1\Controllers\DeviceApiController@save');
    });

    // Password
    $api->group(['prefix' => 'password'], function (Router $api) {
        $api->get('reset/{token?}', 'App\Api\V1\Controllers\Auth\PasswordController@showResetForm');
        $api->post('email', 'App\Api\V1\Controllers\Auth\PasswordController@sendResetLinkEmail');
        $api->post('reset', 'App\Api\V1\Controllers\Auth\PasswordController@reset');
    });


    // User
    $api->group(['prefix' => 'user'], function (Router $api) {
        // Settings
        $api->get('premium', 'App\Api\V1\Controllers\UserApiController@premium');
        $api->post('device', 'App\Api\V1\Controllers\UserApiController@device');
        $api->post('subscribe', 'App\Api\V1\Controllers\UserApiController@subscribe');
        $api->get('summary', 'App\Api\V1\Controllers\UserApiController@summary');
        $api->post('follow', 'App\Api\V1\Controllers\UserApiController@follow');
        // Chat user list
        $api->get('list', 'App\Api\V1\Controllers\UserApiController@list');

        // Comments
        $api->get('comments', 'App\Api\V1\Controllers\CommentApiController@index');
        $api->post('comments', 'App\Api\V1\Controllers\CommentApiController@show');
        $api->post('comment', 'App\Api\V1\Controllers\CommentApiController@process');

        // Likes
        $api->get('likes', 'App\Api\V1\Controllers\LikeApiController@index');
        $api->post('likes', 'App\Api\V1\Controllers\LikeApiController@show');
        $api->post('like', 'App\Api\V1\Controllers\LikeApiController@process');
        $api->post('likes/hots', 'App\Api\V1\Controllers\LikeApiController@hots');

        // Shares
        $api->get('shares', 'App\Api\V1\Controllers\ShareApiController@index');
        $api->post('shares', 'App\Api\V1\Controllers\ShareApiController@show');
        $api->post('share', 'App\Api\V1\Controllers\ShareApiController@process');

        // Booking
        $api->post('booking', 'App\Api\V1\Controllers\BookingApiController@process');

        // Articles
        $api->get('articles', 'App\Api\V1\Controllers\ArticleApiController@index');

        // Profile
        $api->get('video/likes', 'App\Api\V1\Controllers\LikeApiController@videos');
        $api->get('video/uploads', 'App\Api\V1\Controllers\VideoApiController@uploads');
    });

    // Webpage
    $api->group(['prefix' => 'front'], function (Router $api) {
        // Awards
        $api->get('awards', 'App\Api\V1\Controllers\AwardinfoApiController@index');
        $api->get('abouts', 'App\Api\V1\Controllers\AboutApiController@index');
    });

    // Adventure
    $api->group(['prefix' => 'adventure'], function (Router $api) {
        // Deals
        $api->get('deals', 'App\Api\V1\Controllers\DealApiController@index');
        $api->get('deals/{site}', 'App\Api\V1\Controllers\DealApiController@filter');
        $api->get('deal/{id}', 'App\Api\V1\Controllers\DealApiController@edit');

        // Last minutes
        $api->get('lastminutes', 'App\Api\V1\Controllers\LastminuteApiController@index');
        $api->get('lastminutes/{site}', 'App\Api\V1\Controllers\LastminuteApiController@filter');
        $api->get('lastminute/{id}', 'App\Api\V1\Controllers\LastminuteApiController@edit');

        // Resorts
        $api->get('resorts', 'App\Api\V1\Controllers\ResortApiController@index');
        $api->get('resorts/{site}', 'App\Api\V1\Controllers\ResortApiController@filter');
        $api->get('resort/{id}', 'App\Api\V1\Controllers\ResortApiController@edit');
        $api->get('resort/{id}/destinfo', 'App\Api\V1\Controllers\ResortApiController@destinfo');
        $api->post('resort/agDestinfo', 'App\Api\V1\Controllers\ResortApiController@agDestinfo');

        // Restaurants
        $api->get('restaurants', 'App\Api\V1\Controllers\RestaurantApiController@index');
        $api->get('restaurants/{site}', 'App\Api\V1\Controllers\RestaurantApiController@filter');
        $api->get('restaurant/{id}', 'App\Api\V1\Controllers\RestaurantApiController@edit');

        // Accommodations
        $api->get('accommodations', 'App\Api\V1\Controllers\AccommodationApiController@index');
        $api->get('accommodations/{site}', 'App\Api\V1\Controllers\AccommodationApiController@filter');
        $api->get('accommodation/{id}', 'App\Api\V1\Controllers\AccommodationApiController@edit');

        // General infos
        $api->get('destinfos', 'App\Api\V1\Controllers\DestinfoApiController@index');
        $api->get('destinfos/{id}', 'App\Api\V1\Controllers\DestinfoApiController@edit');

        // Other activities
        $api->get('otherActivities', 'App\Api\V1\Controllers\OtherActivityApiController@index');
        $api->get('otherActivities/{id}', 'App\Api\V1\Controllers\OtherActivityApiController@edit');
    });


    // GEO
    $api->group(['prefix' => 'geo'], function (Router $api) {
        $api->post('/', 'App\Api\V1\Controllers\GeoApiController@index');
        $api->get('show/{model}/{id}', 'App\Api\V1\Controllers\GeoApiController@show');
        $api->get('filter/categories', 'App\Api\V1\Controllers\GeoApiController@filterCategories');
        $api->post('airports', 'App\Api\V1\Controllers\GeoApiController@airports');
        $api->post('nearResorts', 'App\Api\V1\Controllers\GeoApiController@nearResorts');

        $api->post('search', 'App\Api\V1\Controllers\GeoApiController@search');
        $api->get('locations', 'App\Api\V1\Controllers\GeoApiController@locations');
    });


    // Destinations
    $api->group(['prefix' => 'area'], function (Router $api) {
        $api->get('countries', 'App\Api\V1\Controllers\CountryStateCityController@countries');
        $api->get('country/{id}', 'App\Api\V1\Controllers\CountryStateCityController@country');

        $api->get('states/{country_id?}', 'App\Api\V1\Controllers\CountryStateCityController@states');
        $api->get('state/{id}', 'App\Api\V1\Controllers\CountryStateCityController@state');

        $api->get('cities/{state_id?}', 'App\Api\V1\Controllers\CountryStateCityController@cities');
        $api->get('city/{id}', 'App\Api\V1\Controllers\CountryStateCityController@city');
    });

    // File
    $api->group(['prefix' => 'file'], function (Router $api) {
        $api->get('/', 'App\Api\V1\Controllers\FileApiController@index');
        $api->get('users/{id?}', 'App\Api\V1\Controllers\FileApiController@users');
        $api->post('upload', 'App\Api\V1\Controllers\FileApiController@upload');
    });

    // Photo
    $api->group(['prefix' => 'photo'], function (Router $api) {
        $api->get('/', 'App\Api\V1\Controllers\PhotoApiController@index');
        $api->get('shared', 'App\Api\V1\Controllers\PhotoApiController@shared');
        $api->get('users/{id?}', 'App\Api\V1\Controllers\PhotoApiController@users');
        $api->post('upload', 'App\Api\V1\Controllers\PhotoApiController@upload');
        $api->post('share', 'App\Api\V1\Controllers\PhotoApiController@share');
    });


    // Video
    $api->group(['prefix' => 'video'], function (Router $api) {
        $api->get('/', 'App\Api\V1\Controllers\VideoApiController@index');
        $api->get('shared', 'App\Api\V1\Controllers\VideoApiController@shared');
        $api->get('users/{id?}', 'App\Api\V1\Controllers\VideoApiController@users');
        $api->get('promo', 'App\Api\V1\Controllers\VideoApiController@promo');
        $api->get('awarded', 'App\Api\V1\Controllers\VideoApiController@awarded');
        $api->post('awarded', 'App\Api\V1\Controllers\VideoApiController@awardedUpload');
        $api->post('upload', 'App\Api\V1\Controllers\VideoApiController@upload');
        $api->get('queue-download/{file}', 'App\Api\V1\Controllers\VideoApiController@queueDownload');
        $api->get('queue-delete/{file}', 'App\Api\V1\Controllers\VideoApiController@queueDelete');

        $api->delete('/{id}', 'App\Api\V1\Controllers\VideoApiController@delete');
    });

    // Contact
    $api->group(['prefix' => 'contact'], function (Router $api) {
        $api->get('/', 'App\Api\V1\Controllers\ContactApiController@get');
        $api->post('/', 'App\Api\V1\Controllers\ContactApiController@create');
        $api->delete('/{id}', 'App\Api\V1\Controllers\ContactApiController@delete');
    });

    // Sites
    $api->get('sites', 'App\Api\V1\Controllers\SiteController@index');


    // Getting groups related with business....
    $api->get('relations', 'App\Api\V1\Controllers\OtherApiController@relations');


    // Tags
    $api->get('tags', 'App\Api\V1\Controllers\TagController@index');


    // Languages
    $api->get('languages', 'App\Api\V1\Controllers\LanguageApiController@index');
    $api->get('translations/{local}', 'App\Api\V1\Controllers\LanguageApiController@translations');


    // Notifications
    $api->group(['prefix' => 'notification'], function (Router $api) {
        $api->post('sms', 'App\Api\V1\Controllers\NotificationApiController@sms');
        $api->post('sns', 'App\Api\V1\Controllers\NotificationApiController@sns');
        $api->post('chat', 'App\Api\V1\Controllers\NotificationApiController@chat');
    });

    // WEB
    $api->group(['prefix' => 'web'], function (Router $api) {
        $api->group(['prefix' => 'tv'], function (Router $api) {
            $api->get('/', 'App\Api\V1\Controllers\TvApiController@tv');
            $api->get('filter', 'App\Api\V1\Controllers\TvApiController@tvFilter');
            $api->get('sorting', 'App\Api\V1\Controllers\TvApiController@sorting');
        });
    });
});
