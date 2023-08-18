<?php

namespace RecursiveTree\Seat\PricesCore\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\PricesCore\Http\DataTables\PriceProviderInstanceDataTable;
use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;
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

    public function deleteInstancePost(Request $request) {
        $request->validate([
            'instance'=>'required|integer'
        ]);

        PriceProviderInstance::destroy($request->instance);

        return redirect()->back()->with('success',trans('pricescore::settings.instance_delete_success'));
    }

    public function editInstance(Request $request) {
        $request->validate([
            'instance'=>'required|integer'
        ]);

        $instance = PriceProviderInstance::find($request->instance);

        if($instance === null) {
            return redirect()->back()->with('success',trans('pricescore::settings.instance_not_found'));
        }

        $backend = config('priceproviders.backends')[$instance->backend];

        if($backend == null){
            return redirect()->back()->with('success',trans('pricescore::settings.price_provider_backend_not_found',['backend'=>$instance->backend]));
        }

        if(!array_key_exists('settings_route', $backend)){
            return redirect()->back()->with('error',trans('pricescore::settings.misconfigured_plugin_info',[
                'plugin'=>trans($backend['plugin'] ?? 'pricescore::settings.unknown_plugin'),
                'price_provider'=>$instance->backend,
            ]));
        }

        $route = $backend['settings_route'];

        return redirect()->route($route,[
            'name'=>$request->name,
            'backend_type'=>$instance->backend,
            'id'=>$instance->id,
            'edit'=>true
        ]);
    }
}