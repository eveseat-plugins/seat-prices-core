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
}