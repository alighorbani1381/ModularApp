<?php

namespace Alighorbani\ModularApp;

use Exception;

class ModularRoute
{
    public array $targetConfig;

    public array $editedTargetConfig = [];

    public static $routeConfigs = [];

    public static function config($key)
    {
        $routeModularObject = new self();

        $routeModularObject->targetConfig = $routeModularObject->getGroupConfig($key);

        return $routeModularObject;
    }

    public static function set($key, $config)
    {
        if (array_key_exists($key, self::$routeConfigs)) {
            throw new Exception($key . ' config is already exists in your config table!');
        }

        self::$routeConfigs[$key] = $config;
    }

    public static function empty()
    {
        self::$routeConfigs = [];
    }

    public function ignore($options)
    {
        $editedConfig = collect($this->targetConfig);

        foreach ($options as $researchKey => $option) {

            foreach ($editedConfig as $key => $value) {
                if ($key != $researchKey) {
                    continue;
                }
                
                foreach ($editedConfig[$key] as $num => $subValue) {
                    
                    if ($subValue != $option) {
                        continue;
                    }
                    
                    $editedConfig[$key] = collect($editedConfig[$key])->forget($num);
                }
            }
        }

        $this->editedTargetConfig = $editedConfig->toArray();

        return $this;
    }

    private function getGroupConfig($key)
    {
        return $this->getValueByKeyOrFail($key, self::$routeConfigs,  " don't exists in your config that you set! ");
    }

    private function getValueByKeyOrFail($key, $array, $message = 'is not exists in your array')
    {
        if (!array_key_exists($key, $array)) {
            throw new Exception($key . " " . $message);
        }

        return $array[$key];
    }

    private function getNormalizedName($name)
    {
        return str_replace('get', '', strtolower($name));
    }

    public function __call($name, $arguments)
    {
        // add for testing in dev mode!
        if ($name == 'getNormalizedName') {
            return $this->$name($arguments[0]);
        }

        if (is_null($this->targetConfig)) {
            throw new Exception($name . "You must call config method before try to get another info ");
        }

        $normalizeName = $this->getNormalizedName($name);

        $exceptionMessage = " Parameter that you want to access this don't exists in your target!";

        if ($normalizeName == 'group') {
            $type = empty($this->editedTargetConfig) ? 'plain' : 'edit';
            return $this->getGroupedConfig($type);
        }

        return $this->getValueByKeyOrFail($normalizeName, $this->targetConfig, $exceptionMessage);
    }

    private function getGroupedConfig($type = 'plain')
    {
        if ($type == 'edit') {
            return $this->editedTargetConfig;
        }

        return $this->targetConfig;
    }
}
