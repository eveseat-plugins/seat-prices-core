<?php

use RecursiveTree\Seat\PricesCore\PriceProviders\SeatPricesPriceProvider;

return [
    'seat_prices_core_seat_prices_provider' => [
        'backend'=> SeatPricesPriceProvider::class,
        'label'=>'pricescore::priceprovider.seat_prices',
        'plugin'=>'recursivetree/seat-prices-core',
        'settings_route' => 'pricescore::instance.new.builtin',
    ]
];
