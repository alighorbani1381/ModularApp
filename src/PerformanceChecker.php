<?php

namespace Modules\Source;

class PerformanceChecker
{
    static function echo_memory_usage()
    {
        $memUsage = memory_get_usage(true);

        if ($memUsage < 1024) {
            return $memUsage . " bytes ";
        }

        if ($memUsage < 1048576) {
            return round($memUsage / 1024, 2) . " kilobytes ";
        }


        return round($memUsage / 1048576, 2) . " megabytes ";
    }

    static function showMemoryUsage($className)
    {
        echo "when run: " . $className . " used  " . static::echo_memory_usage() . " memory" . PHP_EOL;
    }
}
