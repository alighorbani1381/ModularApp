<?php

namespace Modules\Source\Directives;

use EasyBlade\Directives\Directive;

class EmptyResource implements Directive
{

    public static function getTemplate($parameter)
    {
        $part1 = '<div class="col-lg-offset-2"><img class="exists-record" src="' . asset('admin/images/symbols/cherry.png') . '" alt="record Not Found!"><div class="notfound-content"><div class="notfound-header">';

        $part2 = '<h3 class="exists-record-message">' . $parameter . '.</h3>';

        $part3 = '</div><div class="notfound-body"></div></div></div>';

        $finalMessage = $part1 . $part2 . $part3;

        return $finalMessage;

    }

    public static function handle($parameter)
    {
        return self::getTemplate($parameter);
    }
}
