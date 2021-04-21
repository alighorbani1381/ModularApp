<?php

namespace Modules\ModuleName\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Modules\ModuleName\Models\ModuleName;
use Modules\ModuleName\Facades\ModuleNameFacade;


class ModuleNameController extends Controller
{
    
    public function index()
    {
        $moduleName = ModuleNameFacade::indexModuleName();
        return view('ModuleName-index', compact('moduleName'));
    }

    public function store(Request $request)
    {
        ModuleNameFacade::storeModuleName($request);
    }
    
    public function update(Request $request, ModuleName $ModuleName)
    {
        ModuleNameFacade::updateModuleName($request, $ModuleName);
    }
    
    public function edit(ModuleName $ModuleName)
    {
        return view('ModuleName-edit', compact('ModuleName'));
    }

    public function destroy(ModuleName $ModuleName)
    {
        ModuleNameFacade::deleteModuleName($ModuleName);
    }
}
