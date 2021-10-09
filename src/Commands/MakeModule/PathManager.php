<?php

namespace Alighorbani\ModularApp\Commands\MakeModule;

use Alighorbani\ModularApp\Commands\MakeModule\Helper;

trait PathManager
{
    use Helper;

    /**
     * Get Base of Module folder
     * 
     * @return string
     * 
     */
    public function getBaseModuleFolder($name = "")
    {
        return $this->getNestedPath(base_path(), 'modules' .  $name);
    }

    /**
     * Get List of All Module Folders
     * 
     * @return array 
     */
    public function getModuleFolders()
    {
        $rootModule = $this->getBaseModuleFolder();

        return glob($rootModule . '/*', GLOB_ONLYDIR);
    }

    /**
     * 
     * Get path of Migration Module
     * 
     * @return array $moduleMigrationPath
     */
    public function getMigrationFolder($moduleName)
    {
        return $this->getNestedPath('modules', $moduleName, 'DataBase', 'migrations');
    }


    /**
     * 
     * Get Names All Module Created
     * 
     * @return array $moduleNames
     */
    public function getNameOfModules()
    {
        $moduleNames = [];

        $directories = $this->getModuleFolders();

        foreach ($directories as $directory) {

            $moduleName = $this->getLastIndexOfString("/", $directory);

            if ($moduleName == 'Source') {
                continue;
            }

            $moduleNames[] = $moduleName;
        }

        return $moduleNames;
    }



    /**
     * Get Module Path From any Module
     * 
     * @param string $folderName
     * 
     * @param string|null $rootModuleFile
     * 
     */
    public function getModulePath(string $folderName, string $rootModuleFile = null)
    {
        $path =  $this->getBaseModuleFolder(DIRECTORY_SEPARATOR . $folderName);

        if ($rootModuleFile == null) {
            return $path;
        }
        return $this->getNestedPath($path, $rootModuleFile);
    }

    /**
     * Get Sample File Path Create For Duplicate
     * 
     * @param string $fileName
     * 
     * @return string
     */
    public function getSampleModuleFile($fileName)
    {
        return str_replace('\Commands\MakeModule', '', __DIR__) . DIRECTORY_SEPARATOR . 'ModuleStructure' . DIRECTORY_SEPARATOR . $fileName;
        
    }

    /**
     * Create Name of File From Module Create
     * 
     * @param string $prefix
     * 
     * @param string $suffix
     * 
     * @param string $fileExtension
     */
    public function namingWithModule($prefix = '', $suffix = '', $fileExtension = ".php")
    {
        return $prefix . $this->moduleName . $suffix . $fileExtension;
    }

    /**
     * Merge the path array
     * 
     * @param string|array
     * 
     * @return string
     */
    public function getNestedPath(...$items)
    {
        return implode('/', $items);
    }
}
