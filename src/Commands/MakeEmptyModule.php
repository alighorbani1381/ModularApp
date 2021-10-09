<?php

namespace Alighorbani\ModularApp\Commands;

use Illuminate\Console\Command;
use Alighorbani\ModularApp\Commands\MakeModule\MakeModuleEngine;

class MakeEmptyModule extends Command
{

    use MakeModuleEngine;


    protected $signature = 'make:module
                            {--a  : create a public folder like a view, facade} 
                            {--remove  : remove all files from module} 
                            ';

    protected $description = 'Create an Empty Module For Your Application';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $this->handelModule();
    }

    /**
     * Main method hanel any behavior of this command
     * 
     * @return mixed
     */
    public function handelModule()
    {
        $this->warn('to terminate this action enter << C >> Character For Module');

        $moduleName  = $this->ask("Enter Your Module Name:");

        $this->wantToContinue($moduleName);

        $this->handelModuleCommand($moduleName);
    }
}
