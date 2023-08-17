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
            'name'=>'required|string',
            'backend_type'=>['required', new BackendType()]
        ]);

        return view('pricescore::instance.new_seat', ['name'=>$request->name]);
    }
    public function newSeatPriceProviderPost(Request $request){
        $request->validate([
            'name'=>'required|string',
            'type'=>"required|string|in:adjusted_price,highest,lowest,sell_price,buy_price,average_prices,average"
        ]);

        $instance = new PriceProviderInstance();
        $instance->name = $request->name;
        $instance->backend = 'seat_prices_core_seat_prices_provider';
        $instance->configuration = ['price_type'=>$request->type];
        $instance->save();

        return redirect()->route('pricescore::settings')->with('success','Successfully created new price provider instance.');
    }
}