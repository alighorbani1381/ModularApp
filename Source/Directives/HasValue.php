<?php

namespace Alighorbani\Directives;

use EasyBlade\Directives\Directive;

class HasValue implements Directive
{
    public static function getTemplate($parameter)
    {
        return "<?php if(is_countable({$parameter}) && count({$parameter})): ?>";
    }

    public static function handle($parameter)
    {
        return self::getTemplate($parameter);
    }
}
