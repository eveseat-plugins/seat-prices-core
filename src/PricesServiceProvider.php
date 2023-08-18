<?php

namespace RecursiveTree\Seat\PricesCore;

use RecursiveTree\Seat\PricesCore\Contracts\IPriceProviderManager;
use RecursiveTree\Seat\PricesCore\Service\PriceProviderManager;
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
        $this->addMigrations();

        // publish config
        $this->addPublications();
        
        // add views
        $this->addViews();
        
        // load translations
        $this->addTranslations();

        // routes
        $this->addRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->addPermissions();
        $this->addSidebarEntries();

        $this->app->singleton(IPriceProviderManager::class, function () {
            return new PriceProviderManager();
        });
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
    private function addMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
    }
    
    private function addViews(): void{
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'pricescore');
    }

    /**
     * Include the translations and set the namespace.
     */
    private function addTranslations(): void
    {

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'pricescore');
    }

    private function addPermissions(): void {
        $this->registerPermissions(__DIR__ . '/Config/package.permissions.php', 'pricescore');
    }

    private function addSidebarEntries(): void {
        // Include this packages menu items
        $this->mergeConfigFrom(__DIR__ . '/Config/package.sidebar.settings.php', 'package.sidebar.settings.entries');
    }

    /**
     * Include the routes.
     */
    private function addRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
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
        return 'seat-prices-core';
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
