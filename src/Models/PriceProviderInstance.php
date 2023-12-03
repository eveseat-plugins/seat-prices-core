<?php

namespace RecursiveTree\Seat\PricesCore\Models;

use Illuminate\Database\Eloquent\Model;

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