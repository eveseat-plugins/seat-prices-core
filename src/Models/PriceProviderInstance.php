<?php

namespace RecursiveTree\Seat\PricesCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use RecursiveTree\Seat\PricesCore\Contracts\Priceable;
use RecursiveTree\Seat\PricesCore\Contracts\PriceProviderBackend;
use RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException;

/**
 * @property string $name
 * @property string $backend
 * @property array $configuration
 * @property int $id
 * @method PriceProviderInstance | null find(int $id)
 */
class PriceProviderInstance extends Model
{
    public $fillable = [
        'name', 'backend', 'configuration'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'configuration' => 'array',
    ];

    /**
     * Public interface to get prices from this price provider
     *
     * @param Collection<Priceable> $items
     * @return Collection<Priceable>
     * @throws PriceProviderException
     */
    //TODO if generic type hints ever become available, use them here
    public function getPrices(Collection $items): Collection
    {
        // look up backend implementation class
        $backends = config('priceproviders.backends');
        if(!array_key_exists($this->backend,$backends)){
            throw new PriceProviderException(trans('pricescore::settings.price_provider_backend_not_found',['backend'=>$this->backend]));
        }
        $backend_info = $backends[$this->backend];

        if(!array_key_exists('backend',$backend_info)) {
            throw new PriceProviderException(trans('pricescore::settings.price_provider_backend_impl_missing',['backend'=>$this->backend]));
        }
        $BackendClass = $backend_info['backend'];

        if(!is_subclass_of($BackendClass, PriceProviderBackend::class)){
            throw new PriceProviderException(trans('pricescore::settings.price_provider_backend_no_backend', ['backend'=>$this->backend,'class'=>PriceProviderBackend::class]));
        }

        $backend = new $BackendClass($this->configuration);
        return $backend->getPrices($items);
    }
}