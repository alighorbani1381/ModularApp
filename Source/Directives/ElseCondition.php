<?php

namespace Modules\Source\Directives;

use EasyBlade\Directives\Directive;

class ElseCondition implements Directive
{
    public static function getTemplate($parameter)
    {
        return '<?php else: ?>';
    }

    public static function handle($parameter)
    {
        return self::getTemplate($parameter);
    }
}
