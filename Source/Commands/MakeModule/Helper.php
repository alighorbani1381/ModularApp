<?php

namespace Modules\Source\Commands\MakeModule;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait Helper
{
    /**
     * Reararnge index of array 
     * 
     * @param array $moduleNames
     * 
     * @return array $moduleNames
     */
    public function rearangeModuleArray($moduleNames)
    {
        for ($i = 0; $i < count($moduleNames) - 1; $i++) {
            $moduleNames[$i]['row'] = $i + 1;
        }

        return $moduleNames;
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


    /**
     * Create Empty Newline in Console
     * 
     * @param int $count
     * 
     * @return void
     */
    public function newEmptyLine($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            echo "\n";
        }
    }

    /**
     * Create Standard Name of module
     * 
     * @param string $moduleName
     * 
     * @return string $ucfirstModuleName
     */
    public function getStandardModuleName($moduleName)
    {
        return Str::ucfirst($moduleName);
    }

    /**
     * delete all files and folder inside main folder
     * 
     * @param string $dirPath
     * 
     * @return void
     */
    public static function completeDeleteFolder($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != DIRECTORY_SEPARATOR) {
            $dirPath .= DIRECTORY_SEPARATOR;
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {

            if (is_dir($file)) {
                self::completeDeleteFolder($file);
            } else if (file_exists($file)) {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
}
