# Developer Documentation

Thanks for considering to develop against the price provider plugin. 
There are two ways you can interact with this plugin:

1. Use prices from seat-prices-core in your plugin
2. Implement price providers for this plugin

## Architecture
> TODO

### Interfaces
#### HasTypeID
> TODO
#### Priceable
> TODO

## Using prices from seat-prices
Your interaction with price providers will go over the `\RecursiveTree\Seat\Prices\Model\PriceProviderInstance` model.

In your settings interface, you should offer an options to select one of the `PriceProviderInstance` models stored in 
the DB. Store its ID somewhere where you can retrieve it again, for example using SeAT's `setting()` function.

When you need price data, retrieve the `PriceProviderInstance` model the user configured in his settings. 
It should have a `getPrices()` method to retrieve prices.

## Writing Price Providers
Create a class extending from `\RecursiveTree\Seat\Prices\Contracts\PriceProviderBackend` and implement the 
`getPrices` method. 

Create a `priceproviders.backends.php` file in your `Config` directory. Add your price provider to it:
```php
<?php

return [
    'recursive_tree_prices_my_price_provider' => [
        'backend'=>MyPriceProviderBackend::class
    ],
    'recursive_tree_prices_other_price_provider' => [
        'backend'=>OtherPriceProviderBackend::class
    ]
];

```

Lastly, you need to merge the config in your service provider's boot method:
```php
$this->mergeConfigFrom(__DIR__ . '/Config/priceproviders.backends.php','priceproviders.backends');
```

To get them to load in a dev environment, run `vendor:publish --force --all` and then `config:clear`

### Configuration
Some price providers might need to know some additional things to properly compute prices, for example which market 
to use. This is done over the configuration system.

> TODO: How to create configuration

In your `PriceProviderBackend`, configuration is accessible as `$this->configuration`.