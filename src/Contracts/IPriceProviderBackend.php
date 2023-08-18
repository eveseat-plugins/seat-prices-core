<?php

namespace RecursiveTree\Seat\PricesCore\Contracts;

use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException;

interface IPriceProviderBackend
{
    /**
     * Fetches the prices for the items in $items
     * Implementations should store the computed price directly on the Priceable object using the setPrice method.
     * In case an error occurs, a PriceProviderException should be thrown, so that an error message can be shown to the user.
     *
     * @param Collection<IPriceable> $items The items to appraise
     * @param array $configuration The configuration of this price provider backend.
     * @throws PriceProviderException
     */
    //TODO if generic type hints ever become available, use them here
    public function getPrices(Collection $items, array $configuration): void;
}