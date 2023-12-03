# Developer Documentation

Thanks for considering to develop against the price provider plugin.
There are two ways you can interact with this plugin:

1. Use prices from seat-prices-core in your plugin
2. Implement price providers for this plugin

Both use cases are explained in the following document.

For cases that aren't explained in this document, you can take a look at the source code on 
[github](https://github.com/recursivetree/seat-prices-core).

## Installation

[![stable](https://poser.pugx.org/recursivetree/seat-prices-core/v/stable?style=flat-square)](https://packagist.org/packages/recursivetree/seat-prices-core)
[![development](https://poser.pugx.org/recursivetree/seat-prices-core/v/unstable?style=flat-square)](https://packagist.org/packages/recursivetree/seat-prices-core)

Add `recursivetree/seat-prices-core` to the dependencies of your `composer.json`. The latest version can be found on
[packagist](https://packagist.org/packages/recursivetree/seat-prices-core).

Since the default development environment doesn't load dependencies from your plugin's composer.json, it is
recommended to either install the plugin over your .env file or via the dev env.

## Concepts

### Price Provider Backend

A piece of code that implements a backend to load prices. For example, a fuzzworks backend would contact
[https://market.fuzzwork.co.uk/](https://market.fuzzwork.co.uk/) or a SeAT core backend would get the prices from
the `market_prices` table.

### Price Provider Instance

Most price provider backends needs configuration associated with them, for example which market to use. A price
provider instance bundles a backend and it's configuration together and is the interface to plugins consuming prices.
seat-prices-core provides an user interface for management and configuration of price provider instances. Plugins 
consuming prices interact with instances over their ID.

### PHP Interfaces

We are currently in the process of moving some parts of seat-prices-core to the seat core. The following interfaces 
were recently moved to `eveseat/services`: `\RecursiveTree\Seat\PricesCore\Contracts\HasTypeID` and 
`\RecursiveTree\Seat\PricesCore\Contracts\IPriceable`. The old interfaces will still be available for a while, but 
are deprecated and will be eventually removed. The same goes for their example implementations 
`\RecursiveTree\Seat\PricesCore\Utils\EveType` and `\RecursiveTree\Seat\PricesCore\Utils\PriceableEveType`.

#### Seat\Services\Contracts\HasTypeID

An object with a type id.

A basic implementation is available as `Seat\Services\Items\EveType`.

#### Seat\Services\Contracts\IPriceable

An object that can be passed to the price provider system so it's value can be evaluated. You pass a list of
`IPriceable`s into the system to get prices, backends also receive a list of `IPriceable`s.

A basic implementation is available as `Seat\Services\Items\PriceableEveType`.

## Using prices from seat-prices

Your interaction with price providers will go over the `\RecursiveTree\Seat\PricesCore\Facades\PriceProviderSystem`
facade.

In your settings interface, you should offer an options to select one price provider instance. Store its ID somewhere 
where you can retrieve it again, for example using SeAT's `setting()` function. For
convenience, there is a blade partial (`pricescore::utils.instance_selector`) rendering a `<select>` with all available
options for plugins to include. You can provide it a `id` and `name` option for the respective fields on the `<select>`.

> The partial is currently the only supported way to get an ID, but this is subject to change

When you need price data, you can use `PriceProviderSystem::getPrices()` `getPrices()` expects the ID of a price 
rpvoider instance and a 
[laravel collection](https://laravel.com/docs/10.x/collections) of `Priceables` as a second argument. It is noteworthy 
that
`getPrices()` doesn't return a new list of `IPriceable`s, it modifies them using the `IPriceable->setPrice(float 
$price): void` method. The advantage of this is that for example, if you implement `IPriceable` on a model, this allows 
you to directly store it in its properties. For simple use cases, `RecursiveTree\Seat\PricesCore\Utils\PriceableEveType`
is available as a basic implementation.

Don't forget to handle errors, as backends might throw a `\RecursiveTree\Seat\PricesCore\Exceptions\PriceProviderException`
if they fail to get prices. It is recommended to include the error message of the exception in the user-facing error.

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

| Property       | Mandatory | Purpose                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
|----------------|-----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| backend        | yes       | The class implementing the actual price provider code.                                                                                                                                                                                                                                                                                                                                                                                                                                                         |
| label          | yes       | A translation key for the name of the price provider backend.                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| plugin         | yes       | The name of the plugin that provides this price provider backend.                                                                                                                                                                                                                                                                                                                                                                                                                                              |
| settings_route | yes       | When creating a new or editing an existing price provider instance of this backend, this route will be invoked. When editing, a 'id' query parameter is supplied. When creating a new instance, a 'name' query parameter containing the name of the instance is included. This route should display an additional page where users can enter the configuration for this backend. Afterwards, the plugin that supplies the backend is responsible for creating or updating a the price provider instance model. |

Lastly, you need to merge the config in your service provider's boot method:

```php
$this->mergeConfigFrom(__DIR__ . '/Config/priceproviders.backends.php','priceproviders.backends');
```

To get them to load in a dev environment, run `vendor:publish --force --all` and then `config:clear`

### Configuration

Some price providers might need to know some additional things to properly compute prices, for example which market
to use. This is done over the configuration system.

In your `PriceProviderBackend`, configuration is passed as a second argument in the `getPrices` method.

Editing the configuration should be done on the page pointed to by the `settings_route` of the backend registry data.
The mode automatically handles casting from an array to json for database storage.