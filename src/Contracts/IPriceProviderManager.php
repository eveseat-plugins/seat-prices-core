<?php

namespace RecursiveTree\Seat\PricesCore\Contracts;

use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException;

interface IPriceProviderManager
{
    /**
     * @param int $instance_id
     * @param Collection<\Seat\Services\Contracts\IPriceable> $items
     * @throws PriceProviderException
     */
    //TODO if generic type hints ever become available, use them here
    public function getPrices(int $instance_id, Collection $items): void;
}