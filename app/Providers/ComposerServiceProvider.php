<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(ViewFactory $view)
    {
        // Global
        $view->composer('*', 'App\Composers\SidebarComposer');
        $view->composer('auth.emails.password', 'App\Composers\EmailComposer');

        // SystemMessages
        $view->composer('layouts.admin.header.files', 'App\Composers\SystemMessages\FilesComposer');
        $view->composer('layouts.admin.header.notifications', 'App\Composers\SystemMessages\NotificationsComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
