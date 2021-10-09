<?php

namespace Modules\ModuleName;

use Alighorbani\FacadeLoader;
use Alighorbani\ModularInterface;
use Alighorbani\ModulesServiceProvider;
use Modules\ModuleName\Facades\ModuleNameFacade;
use Modules\ModuleName\Repositories\ModuleNameRepository;
use Modules\ModuleName\FakeRepository\FakeModuleNameRepository;

class ModuleNameServiceProvider extends ModulesServiceProvider implements ModularInterface
{

    public $name = "ModuleName";

    public $controllerNamespace = 'Modules\ModuleName\Http\Controllers';


    public function boot()
    {
        $this->defineRouter();

        $this->defineViewer();

        $this->defineMigrator();
    }

    public function register()
    {
        $this->initializeFacade();
    }

    public function initializeFacade()
    {
        FacadeLoader::whenBrowserRunning(function () {

            ModuleNameFacade::shouldProxyTo(ModuleNameRepository::class);
        });

        FacadeLoader::whenUnitTesting(function () {

            ModuleNameFacade::shouldProxyTo(FakeModuleNameRepository::class);
        });
    }
}
