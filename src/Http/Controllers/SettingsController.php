<?php

namespace RecursiveTree\Seat\PricesCore\Http\Controllers;

use RecursiveTree\Seat\PricesCore\Http\DataTables\PriceProviderInstanceDataTable;

class SettingsController extends \Seat\Web\Http\Controllers\Controller
{
    public function view(PriceProviderInstanceDataTable $dataTable){
        return $dataTable->render('pricescore::settings');
    }
}