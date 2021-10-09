<?php

namespace Alighorbani\ModularApp\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Alighorbani\Commands\MakeModule\PathManager;


class MakeMigrationModule extends Command
{
    use PathManager;

    const DEFAULT_OFFSET = 0;

    public $signature = 'make:module-m';

    public $description = 'Create a Migration for any Module you created.';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $migrationPath = $this->getModuleMigrationPath();

        $this->createMigration($migrationPath);
    }

    public function getModuleMigrationPath()
    {
        $moduleNames = $this->getNameOfModules();

        $key = $this->choice('select module do you need?', $moduleNames, self::DEFAULT_OFFSET);

        $index = array_search($key, $moduleNames);

        return $this->getMigrationFolder($moduleNames[$index]);
    }

    public function createMigration($migrationPath)
    {
        $migrationName = $this->ask('What is your Table Name?');

        $command =  $this->generateMigrationCommand($migrationName, $migrationPath);

        $this->executeCommand($command);
    }

    public function generateMigrationCommand($migrationName, $migrationPath)
    {
        return 'make:migration create_' . $migrationName . '_table  --path=' . $migrationPath;
    }

    public function executeCommand($command)
    {
        $this->info("migration generated!");

        Artisan::call($command);
    }
}
