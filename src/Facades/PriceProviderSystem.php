<?php

namespace RecursiveTree\Seat\PricesCore\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use RecursiveTree\Seat\PricesCore\Contracts\IPriceProviderManager;

/**
 * @method static void getPrices(int $instance_id, Collection $items)
 */
class PriceProviderSystem extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return IPriceProviderManager::class;
    }
}