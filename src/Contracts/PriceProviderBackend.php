<?php

namespace RecursiveTree\Seat\PricesCore\Contracts;

use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException;

abstract class PriceProviderBackend
{
    protected array $configuration;

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Public interface to get prices from this price provider
     *
     * @param Collection<Priceable> $items
     * @return Collection<Priceable>
     * @throws PriceProviderException
     */
    //TODO if generic type hints ever become available, use them here
    public final function getPrices(Collection $items): Collection {
        $this->getPricesInternal($items);
        return $items;
    }

    /**
     * Fetches the prices for the items in $items
     * Implementations should store the computed price directly on the Priceable object using the setPrice method.
     * In case an error occurs, a PriceProviderException should be thrown, so that a error message can be shown to the user.
     *
     * @param Collection<Priceable> $items The items to appraise
     * @throws PriceProviderException
     */
    /*
     * This is a second, internal function that backends should implement.
     * The reason we have a second function is that we can implement caching at price provider level in the future
     * without any breaking changes, because we can just inject them into the public getPrices method.
     */
    //TODO if generic type hints ever become available, use them here
    protected abstract function getPricesInternal(Collection $items): void;

}