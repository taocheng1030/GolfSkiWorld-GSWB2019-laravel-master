<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Routing\Router;

Route::get('/', 'HomeController@index');
Route::get('/test', 'UsersController@test');

Route::group(['prefix' => 'admin'], function (Router $router) {
    $router->get('/', 'MainController@index');
    $router->get('main', 'MainController@index');

    // Authentication
    $router->get('login', 'Auth\AuthController@showLoginForm');
    $router->post('login', 'Auth\AuthController@login');
    $router->get('logout', 'Auth\AuthController@logout');
    $router->get('check', 'Auth\ProfileController@check');

    // Registration
    $router->group(['prefix' => 'register'], function (Router $router) {
        $router->get('/', 'Auth\AuthController@showRegistrationForm');
        $router->post('/', 'Auth\AuthController@register');
    });

    // Password Reset
    $router->group(['prefix' => 'password'], function (Router $router) {
        $router->get('reset/{token?}', 'Auth\PasswordController@showResetForm');
        $router->post('email', 'Auth\PasswordController@sendResetLinkEmail');
        $router->post('reset', 'Auth\PasswordController@reset');
    });

    // Profile
    $router->group(['prefix' => 'profile'], function (Router $router) {
        $router->get('/', 'Auth\ProfileController@show');
        $router->post('/', 'Auth\ProfileController@save');
        $router->post('password', 'Auth\ProfileController@password');
        $router->get('summary/{type}', 'Auth\ProfileController@summary');
    });

    // Deals
    $router->resource('deals', 'DealsController');
    $router->group(['prefix' => 'deals'], function (Router $router) {
        $router->get('{id}/booked', 'DealsController@booked');
    });

    // Lastminutes
    $router->resource('lastminutes', 'LastminutesController');
    $router->group(['prefix' => 'lastminutes'], function (Router $router) {
        $router->get('{id}/booked', 'LastminutesController@booked');
    });

    // Notifiaction center
    $router->resource('notifications', 'NotificationsController');
    $router->group(['prefix' => 'notifications'], function (Router $router) {
        $router->post('{id}/push', 'NotificationsController@push');
    });

    // Resorts
    $router->resource('resorts', 'ResortsController');
    $router->group(['prefix' => 'resorts'], function (Router $router) { });

    // Restaurants
    $router->resource('restaurants', 'RestaurantsController');
    $router->group(['prefix' => 'restaurants'], function (Router $router) {
        $router->group(['prefix' => 'sidebar'], function (Router $router) {
            $router->post('add', 'RestaurantsController@sidebarAdd');
            $router->post('delete', 'RestaurantsController@sidebarDelete');
        });
    });

    // Accommodations
    $router->resource('accommodations', 'AccommodationsController');
    $router->group(['prefix' => 'accommodations'], function (Router $router) {
        $router->group(['prefix' => 'sidebar'], function (Router $router) {
            $router->post('add', 'AccommodationsController@sidebarAdd');
            $router->post('delete', 'AccommodationsController@sidebarDelete');
        });
    });

    // Destination
    $router->resource('destinfos', 'DestinfosController');

    // Webpage
    $router->resource('awardinfos', 'AwardinfosController');
    $router->resource('abouts', 'AboutsController');

    // Settings
    $router->resource('articles', 'ArticlesController');
    $router->resource('users', 'UsersController');
    $router->resource('languages', 'LanguagesController');
    $router->resource('translations', 'TranslationsController');
    $router->resource('tags', 'TagsController');

    // Video files
    $router->group(['prefix' => 'videos'], function (Router $router) {
        $router->get('users', 'VideosController@users');
        $router->post('award', 'VideosController@award');
        $router->post('promo', 'VideosController@promo');
        $router->post('upload', 'VideosController@upload');
        $router->post('delete', 'VideosController@delete');
        $router->get('tags', 'VideosController@tags');
        $router->post('tags', 'VideosController@tags');
        $router->get('gsw', 'VideosController@gsw');

        $router->group(['prefix' => 'trash'], function (Router $router) {
            $router->get('/', 'VideosController@trash');
            $router->post('restore', 'VideosController@trashRestore');
            $router->post('delete', 'VideosController@trashDelete');
        });
    });

    // Photo files
    $router->group(['prefix' => 'photos'], function (Router $router) {
        $router->get('users', 'PhotosController@users');
        $router->post('thumbnail', 'PhotosController@thumbnail');
        $router->post('delete', 'PhotosController@delete');
        $router->post('upload', 'PhotosController@upload');
    });

    // Photo files
    $router->group(['prefix' => 'tv'], function (Router $router) {
        $router->get('/', 'TvController@index');
        $router->get('get', 'TvController@get');
        $router->post('get', 'TvController@get');
    });

    // System
    $router->group(['prefix' => 'system'], function (Router $router) {
        // Log viewer
        $router->get('logs', 'LogsController@index');

        // System notification
        $router->group(['prefix' => 'notification'], function (Router $router) {
            $router->post('markRead', 'SystemController@markRead');
        });
    });
});
