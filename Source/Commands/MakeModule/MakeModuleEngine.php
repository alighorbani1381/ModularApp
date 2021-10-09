<?php

namespace Alighorbani\Commands\MakeModule;

use Alighorbani\Commands\MakeModule\PathManager;
use Alighorbani\Commands\MakeModule\ModuleFileManager;

trait MakeModuleEngine
{
    use PathManager;

    use ModuleFileManager;


    public $moduleName;

    public $optionAlias = [
        'a' => 'all',
    ];

    public function setModuleName($name)
    {
        $this->moduleName = $this->getStandardModuleName($name);
    }

    /**
     * 
     * Main Method Work All of This Command
     * 
     * @param string $moduleName
     * 
     * @return mixed
     */
    public function handelModuleCommand($moduleName)
    {
        $this->setModuleName($moduleName);

        $this->wantToDeleteModule($this->moduleName);

        $this->handelCreateBaseModulFolder();

        $this->makeModulesFolder();
    }

    /**
     * Main Module to Delete Module
     * 
     * @param string $moduleName
     * 
     * @return void 
     */
    public function wantToDeleteModule(string $moduleName)
    {
        if (!$this->option('remove')) {
            return true;
        }

        $this->whenModuleDontExists(function () {

            $this->moduleDontExistsAlert();
        });

        $path = $this->getModulePath($moduleName) . DIRECTORY_SEPARATOR;

        static::completeDeleteFolder($path);

        $this->info(" {$moduleName} Module Deleted Successfully!");

        die;
    }

    /**
     * Show Message When Module Don't Exists
     * 
     * @return void
     */
    public function moduleDontExistsAlert()
    {
        $this->newEmptyLine(2);

        $this->error(" Module " . $this->moduleName . " Don't Exists! ");

        $this->newEmptyLine(1);

        $this->warn("this module don't exists to remove");

        $this->newEmptyLine(1);

        die;
    }

    /**
     * 
     * Show All Module Created
     * 
     * @return mixed
     */
    public function showAllModule()
    {
        $directories = $this->getModuleFolders();

        $moduleNames = $this->getModulesName($directories);

        $this->printTableLayout($moduleNames);
    }

    /**
     * 
     * Get Names All Module Created
     * 
     * @param array $directories
     * 
     * @return array $moduleNames
     */
    public function getModulesName($directories)
    {
        $moduleNames = [];

        foreach ($directories as $index => $directory) {

            $moduleName = $this->getLastIndexOfString("/", $directory);

            if ($moduleName == 'Source') {
                continue;
            }

            $moduleNames[$index]['row'] = $index;
            $moduleNames[$index]['Module Name'] = $moduleName;
        }

        return $this->rearangeModuleArray($moduleNames);
    }

    /**
     * 
     * Print Table Layout into Console
     * 
     * @param array $values
     * 
     * @return mixed
     */
    public function printTableLayout($values)
    {
        $headers = ['row', 'Module Name'];

        $this->table($headers, $values);
    }


    /**
     * 
     * Get Status of All Option User set from console
     * 
     * @return array $options
     */
    public function getSpecifyOptions()
    {
        $options = [];

        foreach ($this->optionAlias as $value => $alias) {
            $options[$alias] = $this->option($value);
        }

        return $options;
    }

    /**
     * 
     * Run Action When get option
     * 
     * @param string $rootModuleFolder
     * 
     * @param string $optionName
     */
    public function runActionFromOption($rootModuleFolder, $optionName)
    {
        switch ($optionName) {
            case 'all':

                $this->makePublicFolders();

                $this->makeNestedFolder();

                $this->makeServiceProvider();

                $this->makeReadFileFromSample('routes.php', 'routes.php');

                $this->makeDefaultFacade();

                $this->makeDefaultModel();

                $this->makeDefaultRepository();

                $this->makeFakeRepository();

                $this->makeDefaultController();

                break;

            default:
                // nothnig
                break;
        }
    }


    /**
     * 
     * Check The Module is Exist
     * 
     * @param string $modulePath
     * 
     * @return bool 
     */
    public static function moduleExists($modulePath)
    {
        return is_dir($modulePath) ? true : false;
    }


    /**
     * 
     * Show Message when module Exist already
     * 
     * @return mixed
     */
    public function moduleAlreadyExists()
    {

        $this->newEmptyLine(2);

        $this->error('This Module/Folder already exists!');

        $this->newEmptyLine(2);

        $this->showAllModule();

        die;
    }

    public function wantToContinue($moduleName)
    {

        if (strtolower($moduleName) != 'c') {
            return true;
        }

        $this->newEmptyLine(2);

        $this->warn("Cancel Creatig Module ...");

        $this->newEmptyLine(2);

        $this->showAllModule();

        die;
    }
}
