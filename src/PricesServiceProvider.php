<?php

namespace RecursiveTree\Seat\Prices;

use Seat\Services\AbstractSeatPlugin;

class PricesServiceProvider extends AbstractSeatPlugin
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Inform Laravel how to load migrations
        $this->add_migrations();

        //publish config
        $this->addPublications();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {

    }

    private function addPublications(): void
    {
        $this->publishes([
            __DIR__ . '/Config/priceproviders.backends.php' => config_path('priceproviders.backends.php'),
        ], ['config', 'seat']);
    }

    /**
     * Set the path for migrations which should
     * be migrated by laravel. More informations:
     * https://laravel.com/docs/5.5/packages#migrations.
     */
    private function add_migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }

    /**
     * Return the plugin public name as it should be displayed into settings.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'SeAT Price Provider System Core';
    }

    /**
     * Return the plugin repository address.
     *
     * @return string
     */
    public function getPackageRepositoryUrl(): string
    {
        return 'https://todo.com';
    }

    /**
     * Return the plugin technical name as published on package manager.
     *
     * @return string
     */
    public function getPackagistPackageName(): string
    {
        return 'seat-prices';
    }

    /**
     * Return the plugin vendor tag as published on package manager.
     *
     * @return string
     */
    public function getPackagistVendorName(): string
    {
        return 'recursivetree';
    }
}
