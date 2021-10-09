<?php

namespace Alighorbani\ModularApp;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Alighorbani\ModularApp\ModulePathHelper;
use Illuminate\Contracts\Foundation\Application;

class ModulesServiceProvider extends ServiceProvider
{
    use ModulePathHelper;

    public $name;

    public $controllerNamespace;

    public $migrationPath;

    /**
     * first run service provider constructor
     * 
     * set configuration of module
     */
    public function __construct()
    {
        $app = resolve(Application::class);

        parent::__construct($app);

        $this->setModuleConfig();
    }


    /**
     * Set Configuration File for Module
     * 
     * @param string $path 
     * 
     * @param string $key
     * 
     * @return void
     */
    public function setConfigFile(string $path, string $key)
    {
        $this->mergeConfigFrom($this->modulePath($path, false), $key);
    }

    /**
     * Set Configuration of Module for Service Provider
     * 
     * @return void
     */
    protected function setModuleConfig()
    {
        $this->name = $this->getModuleName(static::class);

        $this->controllerNamespace = 'Modules\\' . $this->name . '\Http\Controllers';
    }

    /**
     * Router Define for module
     * 
     * @param string $routeFilePath
     * 
     * @return void
     */
    protected function defineRouter(string $routeFilePath = 'routes.php')
    {
        Route::middleware('web')
            ->namespace($this->controllerNamespace)
            ->group($this->modulePath($routeFilePath));
    }

    /**
     * Viewer Define for module
     * 
     * @param string $path
     * 
     * @return void
     */
    protected function defineViewer(string $path = 'Views')
    {
        $viewFolderPath = $this->modulePath($path);

        $this->makeFolderNotExists($viewFolderPath);

        View::addLocation($viewFolderPath);
    }

    /**
     * Migrator Define for module
     * 
     * @param $migrationFolderPath
     * 
     * @return void
     */
    protected function defineMigrator(string $migrationFolderPath = 'migrations')
    {
        $path =  $this->dataBasePath($migrationFolderPath);

        $this->loadMigrationsFrom($path);
    }

    /**
     * Factories Define for module
     * 
     * @param $factoriesFolderPath
     * 
     * @return void
     */
    protected function loadFactoriesModule(string $factoriesFolderPath = 'factories')
    {
        $path =  $this->dataBasePath($factoriesFolderPath);

        $this->loadFactoriesFrom($path);
    }

    /**
     * Set All Configuration for module (router, viewer, migration, configFile)
     * 
     * @return void
     */
    protected function setModuleConfiguration($isApi = true)
    {
        $this->defineRouter();

        if (!$isApi) {
            $this->defineViewer();
        }

        $this->defineMigrator();
    }
}
