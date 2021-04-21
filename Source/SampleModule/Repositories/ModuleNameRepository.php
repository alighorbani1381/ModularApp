<?php

namespace Modules\ModuleName\Repositories;

use Illuminate\Http\Request;
use Modules\ModuleName\Models\ModuleName;

class ModuleNameRepository
{
    public function indexModuleName()
    {
        return ModuleName::get()->orderBy('id', 'desc');
    }

    public function storeModuleName(Request $request)
    {
        ModuleName::create($request->all());
    }

    public function updateModuleName(Request $request, ModuleName $ModuleName)
    {
        $ModuleName->update($request->all());
    }

    public function deleteModuleName(ModuleName $ModuleName)
    {
        $ModuleName->delete();
    }
}
