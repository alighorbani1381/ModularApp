<?php

namespace Modules\ModuleName\FakeRepository;

use Illuminate\Support\Facades\Request;
use Modules\ModuleName\Models\ModuleName;


class FakeModuleNameRepository
{
    public function getModuleName()
    {
        return 'ModuleNameGet';
    }

    public function storeModuleName(Request $request)
    {
        return 'ModuleNameStore';
    }

    public function updateModuleName(Request $request, ModuleName $ModuleName)
    {
        return 'ModuleNameUpdate';
    }

    public function deleteModuleName(ModuleName $ModuleName)
    {
        return 'ModuleNameDelete';
    }
}
