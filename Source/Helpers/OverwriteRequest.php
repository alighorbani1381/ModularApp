<?php

namespace Alighorbani\Helpers;

use Illuminate\Support\Facades\App;

class OverwriteRequest
{
    /** @var array */
    private static $replacers;

    public static function add($replacers)
    {
        self::$replacers = (array) $replacers;
    }

    public static function overwrite($requests)
    {
        foreach (self::$replacers as $replacer) {
            App::make($replacer)->replace($requests);
        }

        static::refresh();
    }

    private static function refresh()
    {
        self::$replacers = [];
    }
}
