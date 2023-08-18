<?php

namespace RecursiveTree\Seat\PricesCore\Http\Controllers;

use Illuminate\Http\Request;
use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;
use RecursiveTree\Seat\PricesCore\Validation\BackendType;
use Seat\Web\Http\Controllers\Controller;

class SeatPriceProviderController extends Controller
{

    public function newSeatPriceProvider(Request $request){
        $request->validate([
            'name'=>'nullable|string',
            'backend_type'=>['required', new BackendType()],
            'id'=>'nullable|integer',
            'edit'=>'nullable|bool'
        ]);

        $instance = PriceProviderInstance::find($request->id);

        $name = $request->name ?? $instance->name ?? "";
        $config = $instance->configuration ?? ['price_type'=>'adjusted_price'];

        return view('pricescore::instance.new_seat', ['name'=>$name, 'id'=>$request->id, 'config'=>$config]);
    }
    public function newSeatPriceProviderPost(Request $request){
        $request->validate([
            'name'=>'required|string',
            'type'=>'required|string|in:adjusted_price,highest,lowest,sell_price,buy_price,average_prices,average',
            'id' => 'nullable|integer'
        ]);

        $instance = new PriceProviderInstance();
        if($request->id){
            $instance = PriceProviderInstance::find($request->id);
        }

        $instance->name = $request->name;
        $instance->backend = 'seat_prices_core_seat_prices_provider';
        $instance->configuration = ['price_type'=>$request->type];
        $instance->save();

        return redirect()->route('pricescore::settings')->with('success','Successfully created new price provider instance.');
    }
}