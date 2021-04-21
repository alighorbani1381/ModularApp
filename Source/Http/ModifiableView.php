<?php

namespace Modules\Source\Http;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class ModifiableView
{
    const CREATE_STATUS = false;

    const EDIT_STATUS = true;

    /** @var array */
    public static $viewComposers = [];

    public $routeName;

    public $editMode;

    public function createMode(string $routeName)
    {
        $this->runManuallyViewComposers();

        return $this->setMode(self::CREATE_STATUS, $routeName, null);
    }

    public function editMode(string $routeName, $routeParams)
    {
        return $this->setMode(self::EDIT_STATUS, $routeName, $routeParams);
    }

    private function setMode($editModeActive, $routeName, $routeParams = null)
    {
        $this->setModifyStatus($editModeActive);

        $this->routeParams = $routeParams;

        $this->routeName = $routeName;

        return $this;
    }

    private function setModifyStatus($defaultModeEdit = true)
    {
        $status = $defaultModeEdit ? self::EDIT_STATUS : self::CREATE_STATUS;

        $this->editMode = $status;
    }

    public function publishViewComposer($view, $composer)
    {
        self::$viewComposers[] = [$view => $composer];
    }

    private function getFlattenList()
    {
        return Collection::make(self::$viewComposers)->mapWithKeys(function ($key) {
            return $key;
        });
    }

    private function runManuallyViewComposers()
    {
        $viewComposers = $this->getFlattenList();

        foreach ($viewComposers as $viewName => $composer) {
            View::composer($viewName, $composer);
        }
    }
}
