<?php

namespace Modules\Source;

use Illuminate\Support\Facades\App;

class FacadeLoader
{
    public static function whenUnitTesting($callback)
    {
        if (App::runningUnitTests()) {
            call_user_func($callback);
        }
    }

    public static function whenBrowserRunning($callback)
    {
        if (!App::runningUnitTests()) {
            call_user_func($callback);
        }
    }
}
