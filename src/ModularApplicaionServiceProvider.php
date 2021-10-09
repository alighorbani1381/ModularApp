<?php

namespace Alighorbani\ModularApp;

use Illuminate\Support\ServiceProvider;
use Alighorbani\ModularApp\Commands\MakeEmptyModule;
use Alighorbani\ModularApp\Commands\MakeMigrationModule;


class ModularApplicaionServiceProvider extends ServiceProvider
{
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

    public function register()
    {
        $this->registerCommands();
    }
}
