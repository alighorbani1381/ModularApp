<?php

namespace Alighorbani\Directives;

use EasyBlade\Directives\Directive;

class AjaxLoaderDirective implements Directive
{
    public static function getTemplate()
    {
        return '
        <svg class="ajax-loading"
           style="display: none !important; width: 48px;position: absolute;height: 48px;margin: 0px auto;left: 0px;  top: 10px;margin: auto; background: none; display: block; shape-rendering: auto;"
           width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
           <circle cx="50" cy="50" r="32" stroke-width="8" stroke="#2c73dd"
              stroke-dasharray="50.26548245743669 50.26548245743669" fill="none" stroke-linecap="round"
              transform="rotate(325.951 50 50)">
              <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.3s"
                 keyTimes="0;1" values="0 50 50;360 50 50"></animateTransform>
           </circle>
        </svg>
        ';
    }

    public static function handle($parameter)
    {
        return self::getTemplate();
    }
}
