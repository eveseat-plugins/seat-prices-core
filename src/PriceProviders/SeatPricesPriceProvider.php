<?php

namespace RecursiveTree\Seat\PricesCore\PriceProviders;
use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Contracts\Priceable;
use RecursiveTree\Seat\PricesCore\Contracts\PriceProviderBackend;
use Seat\Eveapi\Models\Sde\InvType;

class SeatPricesPriceProvider implements PriceProviderBackend
{

    /**
     * Fetches the prices for the items in $items
     * Implementations should store the computed price directly on the Priceable object using the setPrice method.
     * In case an error occurs, a PriceProviderException should be thrown, so that an error message can be shown to the user.
     *
     * @param Collection<Priceable> $items The items to appraise
     * @param array $configuration The configuration of this price provider backend.
     */
    public function getPrices(Collection $items, array $configuration): void
    {
        $price_type = $configuration['price_type'];

        foreach ($items as $item) {
            $invType = InvType::with('price')->where("typeID",$item->getTypeID())->first();
            $price = $invType->price->$price_type ?? $invType->basePrice ?? 0;
            $item->setPrice($price * $item->getAmount());
        }
    }
}