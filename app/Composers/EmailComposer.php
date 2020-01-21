<?php

namespace App\Composers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class EmailComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('isApi', Controller::$isApi);
    }

}