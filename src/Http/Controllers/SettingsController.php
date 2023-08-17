<?php

namespace RecursiveTree\Seat\PricesCore\Http\Controllers;

class SettingsController extends \Seat\Web\Http\Controllers\Controller
{
    public function view(){
        return view('pricescore::settings');
    }
}