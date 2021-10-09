<?php

namespace Modules\Source;

use Illuminate\Support\Facades\Blade;
use Alighorbani\Http\ModifiableView;
use Illuminate\Support\ServiceProvider;
use Alighorbani\Facade\ModifiableFacade;

use Alighorbani\Commands\{
    MakeEmptyModule,
    MakeMigrationModule,
};

use Alighorbani\Directives\{
    HasValue,
    EndCondition,
    ElseCondition,
    EmptyResource,
    AjaxLoaderDirective,
};

use Alighorbani\Directives\Modifiable\{
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
