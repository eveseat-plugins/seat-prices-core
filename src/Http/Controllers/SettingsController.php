<?php

namespace RecursiveTree\Seat\PricesCore\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\PricesCore\Http\DataTables\PriceProviderInstanceDataTable;
use RecursiveTree\Seat\PricesCore\Validation\BackendType;

class SettingsController extends \Seat\Web\Http\Controllers\Controller
{
    public function view(PriceProviderInstanceDataTable $dataTable){
        return $dataTable->render('pricescore::settings');
    }

    public function newInstance(){
        return view('pricescore::instance.new');
    }

    public function newInstancePost(Request $request){
        $request->validate([
            'name'=>'required|string',
            'type'=> ['required', new BackendType()]
        ]);

        $backend = config('priceproviders.backends')[$request->type];

        if(!array_key_exists('settings_route', $backend)){
            return redirect()->back()->with('error',trans('pricescore::settings.misconfigured_plugin_info',[
                'plugin'=>trans($backend['plugin'] ?? 'pricescore::settings.unknown_plugin'),
                'price_provider'=>$request->type,
            ]));
        }

        $route = $backend['settings_route'];

        return redirect()->route($route,[
            'name'=>$request->name,
            'backend_type'=>$request->type,
        ]);
    }
}