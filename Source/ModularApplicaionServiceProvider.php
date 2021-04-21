<?php

namespace Modules\Source;

use Illuminate\Support\Facades\Blade;
use Modules\Source\Http\ModifiableView;
use Illuminate\Support\ServiceProvider;
use Modules\Source\Facade\ModifiableFacade;

use Modules\Source\Commands\{
    MakeEmptyModule,
    MakeMigrationModule,
};

use Modules\Source\Directives\{
    HasValue,
    EndCondition,
    ElseCondition,
    EmptyResource,
    AjaxLoaderDirective,
};

use Modules\Source\Directives\Modifiable\{
    ModifyParam,
    ModifyFormRequirement
};


class ModularApplicaionServiceProvider extends ServiceProvider
{

    /** @var array */

    const CUSTOM_DIRECTIVES = [

        // Helpers Directives (show stuff in HTML)
        'ajaxLoader' => AjaxLoaderDirective::class,

        'emptyResource' => EmptyResource::class,


        // Has Value Directives
        'hasValue' => HasValue::class,

        'endHasValue' => EndCondition::class,

        'dosentValue' => ElseCondition::class,


        // Modifiable View Directives
        'modifyFormParam' => ModifyFormRequirement::class,

        'modifyParam' => ModifyParam::class,
    ];

    /**
     * Register Custom Command ModularApplicaion
     * 
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEmptyModule::class,
                MakeMigrationModule::class,
            ]);
        }
    }

    /**
     * Set All Custom Directives !
     * 
     * @return void
     */
    protected function registerDirectives()
    {
        foreach (static::CUSTOM_DIRECTIVES as $directive => $class) {
            Blade::directive($directive, [$class, 'handle']);
        }
    }

    protected function initializeFacades()
    {
        ModifiableFacade::shouldProxyTo(ModifiableView::class);
    }


    public function register()
    {
        $this->initializeFacades();

        $this->registerCommands();

        $this->registerDirectives();
    }
}
