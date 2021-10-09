<?php

namespace Alighorbani\Directives\Modifiable;

use EasyBlade\Directives\Directive;
use Alighorbani\Http\ModifiableView;

class ModifyFormRequirement implements Directive
{
    public static function handle($parameter)
    {
        return "<?php echo \\Modules\\Source\\Directives\\Modifiable\\ModifyFormRequirement::render($parameter); ?>";
    }

    /**
     * Render the ModifyFormRequirement Directive
     * 
     * when form used for edit addional csrf_token add method insted of @method Directive
     * 
     * @param object $formParam
     * 
     * @param string $method
     * 
     * @return string $output
     */
    public static function render(ModifiableView $formParam, string $method)
    {
        $output = csrf_field();

        if ($formParam->editMode) {
            $output .= method_field($method);
        }

        return $output;
    }
}
