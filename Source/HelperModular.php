<?php

namespace Modules\Source;

trait HelperModular
{
    public function removeLastMember(array $array)
    {
        $lastIndex = count($array) - 1;
        unset($array[$lastIndex]);
        return $array;
    }

    public function slashPath($path)
    {
        return str_replace('\\', '/', $path);
    }

    public function makeFolderNotExists($folderPath)
    {
        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }
    }
}
