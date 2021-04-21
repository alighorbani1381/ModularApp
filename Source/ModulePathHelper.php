<?php

namespace Modules\Source;

use Exception;
use Modules\Source\HelperModular;

trait ModulePathHelper
{
    use HelperModular;

    public function getModulePath()
    {
        $path = $this->getBasePath(__DIR__) . DIRECTORY_SEPARATOR . $this->name;

        $path = $this->slashPath($path);
        
        if (is_dir($path)) {
            return $path;
        }

        throw new Exception("Name of Module must same folder ! but you enter {$this->name} does not Exits this folder");
    }

    public function getBasePath($path)
    {
        $array = explode(DIRECTORY_SEPARATOR, $path);

        $array = $this->removeLastMember($array);

        return implode(DIRECTORY_SEPARATOR, $array);
    }

    public function dataBasePath($path)
    {
        return $this->modulePath('DataBase' . DIRECTORY_SEPARATOR . $path);
    }

    public function modulePath(string $path = '', $backslash = true)
    {
        $modulePath = $this->getModulePath() . DIRECTORY_SEPARATOR . $path;

        return $backslash ? $modulePath : $this->slashPath($modulePath);
    }

    /**
     * Get the Last item when explode string
     * 
     * @param string $seprator
     * 
     * @return string $text
     */
    public function getLastIndexOfString($seprator, $text)
    {
        $items = explode($seprator, $text);

        return end($items);
    }

    public function getModuleName($serviceProviderName)
    {
        $classPath = str_replace('ServiceProvider', '', $serviceProviderName);

        return $this->getLastIndexOfString("\\", $classPath);
    }
}
