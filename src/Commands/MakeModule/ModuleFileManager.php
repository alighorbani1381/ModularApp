<?php

namespace Alighorbani\Commands\MakeModule;

use PHP_Parallel_Lint\PhpConsoleColor\ConsoleColor;

trait ModuleFileManager
{

    /**
     * List of folders Create for any Module
     * 
     * @var array
     */
    public $folders = [
        'DataBase' => ['factory', 'migrations'],
        'Http' => ['Controllers', 'Requests'],
        'Facades',
        'FakeRepository',
        'Repositories',
        'tests',
        'Models',
        'Views',
    ];

    /**
     * 
     * Create modules Folder in Laravel Root Folder
     * 
     * @return void
     */
    public function handelCreateBaseModulFolder()
    {
        $rootModuleFolder = $this->getBaseModuleFolder();

        $this->moduleMkDir($rootModuleFolder);
    }

    public function whenModuleExists($callback)
    {

        $moudulePath = $this->getModulePath($this->moduleName);

        if (MakeModuleEngine::moduleExists($moudulePath)) {
            call_user_func($callback);
        }
    }

    public function whenModuleDontExists($callback)
    {
        $modulePath = $this->getModulePath($this->moduleName);

        if (!MakeModuleEngine::moduleExists($modulePath)) {
            call_user_func($callback);
        }
    }

    /**
     * main method create all module folder 
     * 
     * @param $moduleName
     * 
     * @return void
     */
    public function makeModulesFolder()
    {

        $this->whenModuleExists(function () {
            $this->moduleAlreadyExists();
        });

        $modulePath = $this->getModulePath($this->moduleName);

        $this->moduleMkDir($modulePath);

        $this->makeFolderInsideModule($this->getSpecifyOptions());

        $this->showSuccessfulMessage();
    }

    /**
     * 
     * print successful message on command line
     * 
     * @return void
     */
    public function showSuccessfulMessage()
    {
        $this->info("Module Created Successfuly !");

        $printer = resolve(ConsoleColor::class);

        echo PHP_EOL . PHP_EOL;

        echo $printer->apply('yellow', "Important Tip: ");

        echo PHP_EOL;

        echo $printer->apply('red', "to active your module add class into providers array");

        echo PHP_EOL . PHP_EOL;
    }
    
    /**
     * 
     * Create a Directory from Module Path When doesn't Exists
     * 
     * @param string|array $path
     * 
     * @return void
     */
    public function moduleMkDir($path)
    {
        $directories = (array) $path;
        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
        }
    }

    /**
     * 
     * Main Method to run all Method that Options set
     * 
     * @param string $modulePath
     * 
     * @param array $options
     */
    public function makeFolderInsideModule(array $options)
    {
        $modulePath = $this->getModulePath($this->moduleName);

        foreach ($options as $optionName => $optionStatus) {
            if ($optionStatus == false) {
                continue;
            }
            $this->runActionFromOption($modulePath, $optionName);
        }
    }


    public function getNestedFolders()
    {
        $condition = function ($key) {
            return is_array($key);
        };

        $keys = $this->getFolder($condition, $this->folders);


        return $this->makeNestedAddress($keys);
    }

    function makeNestedAddress($folders)
    {
        $paths = [];


        $mainFolders = array_keys($folders);


        foreach ($mainFolders as $mainfolder) {
            foreach ($folders[$mainfolder] as $subFolder) {
                $subFolder =  $mainfolder . DIRECTORY_SEPARATOR . $subFolder;
                $paths[] = $this->getModulePath($this->moduleName, $subFolder);
            }
        }
        return $paths;
    }

    /**
     * 
     * Make Address From Folders List
     * 
     * @param array $keys
     * 
     * @param string $rootModuleFolder
     * 
     * @return array $folderAddresses
     */
    public function makeFolderAddress($keys)
    {
        $folderAddresses = [];

        $rootModuleFolder = $this->getModulePath($this->moduleName);

        foreach ($keys as $key) {
            $folderAddresses[] = $rootModuleFolder . DIRECTORY_SEPARATOR . $this->folders[$key];
        }
        return $folderAddresses;
    }

    /**
     * 
     * Get Specify Folder with Custom Condition
     * 
     * @param Clouser $condition
     * 
     * @param array $folders
     * 
     * @return array $specifyFolder
     */
    public function getFolder($condition, $folders)
    {
        $specifyFolder = [];

        foreach ($folders as $key => $folder) {
            if ($condition($folder)) {
                $specifyFolder[$key] = $folder;
            }
        }
        return $specifyFolder;
    }

    public function getRootFolders()
    {
        return function ($key) {
            return is_numeric($key);
        };
    }

    /**
     * 
     * Replace Specify Word From File Content
     * 
     * @param string $filePath 
     * 
     * @param string $find
     * 
     * @param string $replace
     * 
     * @return string replacedContent
     * 
     */
    public function getFileAndReplace($filePath, $find, $replace)
    {
        if (!file_exists($filePath)) {
            return str_replace($find, $replace, $filePath);
        }

        $file = file_get_contents($filePath);

        return str_replace($find, $replace, $file);
    }

    /**
     * 
     * Write a Correct Content From file and save
     * 
     * @param string $path
     * 
     * @param mixed $content
     */
    public function writeFileAndSave($path, $content)
    {
        $file = fopen($path, 'w');

        fwrite($file, $content);

        fclose($file);
    }

    /**
     * 
     * Create a Copy Sample Module into Created Module
     * 
     * @param string $sampleFileName
     * 
     * @return void saving new file from module path
     */
    public function makeReadFileFromSample($sampleFileName, $newFileName, $targetReplace = 'ModuleName', $callback = null)
    {
        $sampleFileContent = $this->getSampleModuleFile($sampleFileName);

        $newFileContent = $this->getFileAndReplace($sampleFileContent, $targetReplace, $this->moduleName);

        $newFileContent = $this->runClouser($callback)($newFileContent);

        $sampleFileName = $this->getAddressToSave($newFileName);

        $this->writeFileAndSave($sampleFileName, $newFileContent);
    }

    /**
     * Run Specific Work After Replace Text From File
     * 
     * @param Clousuer $callback
     * 
     * @return Clousuer
     */
    public function runClouser($callback)
    {
        if (is_callable($callback)) {
            return $callback;
        }

        return function ($value) {
            return $value;
        };
    }


    /**
     * Attach Name of CustomFile into Module Name
     * 
     * @param string $path
     * 
     * @return string $targetModulePath
     */
    public function getAddressToSave($path)
    {
        $targetModulePath = $this->getModulePath($this->moduleName);

        return $targetModulePath . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * Get Clouser of variable fix Convention from php-fig
     * 
     * @return Clouser
     */
    public function variableFixConvention()
    {
        return function ($fileContent) {

            $targetVar = '$' . $this->moduleName;

            return $this->getFileAndReplace($fileContent, $targetVar, strtolower($targetVar));
        };
    }



    /**
     * Create Service Provider For Module
     * 
     * @return void
     */
    public function makeServiceProvider()
    {
        $saveTo = $this->namingWithModule('', 'ServiceProvider');

        $this->makeReadFileFromSample('ModuleServiceProvider.php', $saveTo);
    }

    /**
     * Make Default Facade For Module When Created
     * 
     * @return void
     */
    public function makeDefaultFacade()
    {
        $saveTo = $this->getNestedPath('Facades', $this->namingWithModule('', 'Facade'));

        $sampleFilePath = $this->getNestedPath('Facades', 'ModuleNameFacade.php');

        $this->makeReadFileFromSample($sampleFilePath, $saveTo);
    }

    /**
     * Make Default Controller For Module When Created
     * 
     * @return void
     */
    public function makeDefaultController()
    {
        $controllerPath = $this->getNestedPath('Http', 'Controllers');

        $sampleFilePath = $this->getNestedPath($controllerPath, 'ModuleNameController.php');

        $saveTo =  $controllerPath . DIRECTORY_SEPARATOR . $this->namingWithModule('', 'Controller');

        $this->makeReadFileFromSample($sampleFilePath, $saveTo, 'ModuleName', $this->variableFixConvention());
    }

    /**
     * Make Default Controller For Module When Created
     * 
     * @return void
     */
    public function makeDefaultModel()
    {

        $sampleFilePath = $this->getNestedPath('Models', 'ModuleName.php');

        $saveTo = $this->getNestedPath('Models', $this->namingWithModule());

        $this->makeReadFileFromSample($sampleFilePath, $saveTo);
    }

    /**
     * Make Default Repository For Module When Created
     * 
     * @return void
     */
    public function makeDefaultRepository()
    {

        $sampleFilePath = $this->getNestedPath('Repositories', 'ModuleNameRepository.php');

        $saveTo =  $this->getNestedPath('Repositories', $this->namingWithModule('', 'Repository'));

        $this->makeReadFileFromSample($sampleFilePath, $saveTo, 'ModuleName', $this->variableFixConvention());
    }


    /**
     * Make Fake Repository For Module When Created
     * 
     * @return void
     */
    public function makeFakeRepository()
    {

        $sampleFilePath =  $this->getNestedPath('FakeRepository', 'FakeModuleNameRepository.php');

        $saveTo = $this->getNestedPath('FakeRepository', $this->namingWithModule('Fake', 'Repository'));

        $this->makeReadFileFromSample($sampleFilePath, $saveTo, 'ModuleName', $this->variableFixConvention());
    }

    /**
     * Create Nested Folder together
     * 
     * @return void
     */
    public function makeNestedFolder()
    {
        $nestedFoldersPath = $this->getNestedFolders();

        $this->moduleMkDir($nestedFoldersPath);
    }

    /**
     * Create non Nested Folders From Module 
     * 
     * @param string $rootModuleFolder
     * 
     * @return void
     */
    public function makePublicFolders()
    {
        $keys = $this->getFolder($this->getRootFolders(), array_keys($this->folders));

        $directories = $this->makeFolderAddress($keys);

        $this->moduleMkDir($directories);
    }
}
