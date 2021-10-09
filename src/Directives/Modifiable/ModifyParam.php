<?php

namespace Alighorbani\Directives\Modifiable;

use EasyBlade\Directives\Directive;
use Illuminate\Database\Eloquent\Model;
use Alighorbani\Http\ModifiableView;

class ModifyParam implements Directive
{
    public static function handle($parameter)
    {
        return "<?php echo \\Modules\\Source\\Directives\\Modifiable\\ModifyParam::render($parameter); ?>";
    }

    /**
     * Render the ModifyParam Directive
     * 
     * When form used for this directive you can say to your blade hey this is a modify view
     * And automatily handel behave like a edit mode or create mode 
     * 
     * @param \Modules\Source\Http\ModifiableView $formParam
     * 
     * @param string $oldKey
     * 
     * @param object|null $modifyObject
     * 
     * @return string
     */
    public static function render(ModifiableView $formParam, string $oldKey, $modifyObject = null)
    {

        if (!$formParam->editMode) {
            return old($oldKey);
        }

        if ($modifyObject instanceof Model && $modifyObject->getAttributes($oldKey)) {
            // @TODO: check this attribute is exitst from this object or no?
            return $modifyObject->$oldKey;
        }

        return $modifyObject;
    }
}
