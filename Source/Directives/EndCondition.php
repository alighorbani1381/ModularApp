<?php

namespace Modules\Source\Directives;

use EasyBlade\Directives\Directive;

class EndCondition implements Directive
{
    public static function getTemplate($parameter)
    {
        return '<?php endif; ?>';
    }

    public static function handle($parameter)
    {
        return self::getTemplate($parameter);
    }
}
