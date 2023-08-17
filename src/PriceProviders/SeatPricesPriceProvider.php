<?php

namespace RecursiveTree\Seat\PricesCore\PriceProviders;
use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Contracts\Priceable;
use RecursiveTree\Seat\PricesCore\Contracts\PriceProviderBackend;
use Seat\Eveapi\Models\Sde\InvType;

class SeatPricesPriceProvider extends PriceProviderBackend
{

    /**
     * This is a second, internal function that backends should implement.
     * The reason we have a second function is that we can implement caching at price provider level in the future
     * without any breaking changes, because we can just inject them into the public getPrices method.
     * Implementations store the computed price directly on the Priceable object.
     * This allows some optimisations compared to returning new priceable objects when implementing priceable on a model.
     *
     * @param Collection<Priceable> $items The items to appraise
     */
    protected function getPricesInternal(Collection $items): void
    {
        $price_type = $this->configuration['price_type'];

        foreach ($items as $item) {
            $invType = InvType::with('price')->where("typeID",$item->getTypeID())->first();
            $price = $invType->price->$price_type ?? $invType->basePrice ?? 9;
            $item->setPrice($price * $item->getAmount());
        }
    }
}