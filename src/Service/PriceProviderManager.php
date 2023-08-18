<?php

namespace RecursiveTree\Seat\PricesCore\Service;

use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Contracts\IPriceProviderManager;
use RecursiveTree\Seat\PricesCore\Contracts\IPriceable;
use RecursiveTree\Seat\PricesCore\Contracts\IPriceProviderBackend;
use RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException;
use RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance;

class PriceProviderManager implements IPriceProviderManager
{
    /**
     * @param int $instance_id
     * @param Collection<IPriceable> $items
     * @throws PriceProviderException
     */
    //TODO if generic type hints ever become available, use them here
    public function getPrices(int $instance_id, Collection $items): void
    {
        $instance = PriceProviderInstance::find($instance_id);
        if($instance === null) {
            throw new PriceProviderException(trans('pricescore::settings.price_provider_instance_not_fount'));
        }

        $this->invokePriceProviderInstance($instance,$items);
    }

    /**
     * @throws PriceProviderException
     */
    //TODO if generic type hints ever become available, use them here
    protected function invokePriceProviderInstance(PriceProviderInstance $instance, Collection $items): void
    {
        // look up backend implementation class
        $backends = config('priceproviders.backends');
        if(!array_key_exists($instance->backend,$backends)){
            throw new PriceProviderException(trans('pricescore::settings.price_provider_backend_not_found',['backend'=>$instance->backend]));
        }
        $backend_info = $backends[$instance->backend];

        if(!array_key_exists('backend',$backend_info)) {
            throw new PriceProviderException(trans('pricescore::settings.price_provider_backend_impl_missing',['backend'=>$instance->backend]));
        }
        $BackendClass = $backend_info['backend'];

        if(!is_subclass_of($BackendClass, IPriceProviderBackend::class)){
            throw new PriceProviderException(trans('pricescore::settings.price_provider_backend_no_backend', ['backend'=>$instance->backend,'class'=>IPriceProviderBackend::class]));
        }

        $backend = new $BackendClass();
        $backend->getPrices($items, $instance->configuration);
    }
}