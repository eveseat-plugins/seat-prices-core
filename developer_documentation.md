# Developer Documentation

Thanks for considering to develop against the price provider plugin.
There are two ways you can interact with this plugin:

1. Use prices from seat-prices-core in your plugin
2. Implement price providers for this plugin

Both use cases are explained in the following document.

## Architecture

The way you interact with the seat-prices-core depends on what you want to achieve. You can either provide a
price provider backend or consume data from a price provider instance. A backend is the code responsible for
providing prices. However, you shouldn't directly interact with a backend. Experience has shown that backends can't
just take in the items they should appraise and spit out prices, most of the time they also need some configuration like
which market to use, or whether to use buy or sell prices. Additionally, experience tells most backends need different
kinds of configuration. Letting plugins that consume prices handle supplying the correct configuration to the correct
price provider backend is cumbersome and takes their focus away from what they actually want to do: consume prices.
Therefore, seat-prices-core has another layer: Instances bundle a backend and it's configuration together in an
easy-to-use bundle for plugins that want to consume prices. Allowing plugins to offer different backends is as simple as
offering to choose them a instance form a list. Creating and configuring instances is handled over the UI in
seat-prices-core and the plugin supplying the backend.

## Installation

[![stable](https://poser.pugx.org/recursivetree/seat-prices-core/v/stable?style=flat-square)](https://packagist.org/packages/recursivetree/seat-prices-core)
[![development](https://poser.pugx.org/recursivetree/seat-prices-core/v/unstable?style=flat-square)](https://packagist.org/packages/recursivetree/seat-prices-core)

Add `recursivetree/seat-prices-core` to the dependencies of your `composer.json`. The latest version can be found on
[packagist](https://packagist.org/packages/recursivetree/seat-prices-core).

Since the default development environment doesn't load dependencies from your plugin's composer.json, it is
recommended to either install the plugin over your .env file or via the dev env.

## Concepts
### Interfaces
#### HasTypeID
An object with a type id.

#### Priceable
An object that can be passed to the price provider system so it's value can be evaluated. You pass a list of 
`Priceable`s into the system to get prices, backends also receive a list of `Priceable`s.

## Using prices from seat-prices

Your interaction with price providers will go over the `\RecursiveTree\Seat\PricesCore\Models\PriceProviderInstance`
model.

In your settings interface, you should offer an options to select one of the `PriceProviderInstance` models stored in
the DB. Store its ID somewhere where you can retrieve it again, for example using SeAT's `setting()` function.

When you need price data, retrieve the `PriceProviderInstance` model the user configured in his settings.
It should have a `getPrices()` method to retrieve prices. Don't forget to handle errors, backends might throw a 
`\RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException` if they fail to get prices. It is recommended to 
include the error message of the exception in the user-facing error.

## Writing Price Providers

Create a class extending from `\RecursiveTree\Seat\PricesCore\Contracts\PriceProviderBackend` and implement the
`getPrices` method.

Create a `priceproviders.backends.php` file in your `Config` directory. Add your price provider to it:

```php
<?php

return [
    'recursive_tree_prices_my_price_provider' => [
        'backend'=>MyPriceProviderBackend::class,
        'label'=>'myplugin::translation.key',
        'plugin'=>'me/myplugin',
        'settings_route' => 'myplugin::my.route',
    ],
    'recursive_tree_prices_other_price_provider' => [
        'backend'=>OtherPriceProviderBackend::class,
        'label'=>'myplugin::translation.key2',
        'plugin'=>'me/myplugin',
        'settings_route' => 'myplugin::my.route',
    ]
];
```

| Property       | Mandatory | Purpose                                                                                                                                                                                                                                                                                                                                                                            |
|----------------|-----------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| backend        | yes       | The class implementing the actual price provider code.                                                                                                                                                                                                                                                                                                                             |
| label          | yes       | A translation key for the name of the price provider backend.                                                                                                                                                                                                                                                                                                                      |
| plugin         | yes       | The name of the plugin that provides this price provider backend.                                                                                                                                                                                                                                                                                                                  |
| settings_route | yes       | When creating a new instance of this backend, this route will be invoked.  It might contain a 'name' query parameter containing the name of the instance. This route should display an additional page where users can enter the configuration for this backend. Afterwards, the plugin that supplies the backend is responsible for creating a new price provider instance model. |

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