<?php

Route::group([
    'namespace'  => 'RecursiveTree\Seat\PricesCore\Http\Controllers',
], function () {

    // hack this into the prefix namespace of the seat settings, so we can have our settings in the same sidebar group as seat core settings
    // the other part of this hack is in package.sidebar.settings.php and the service provider
    Route::group([
        'middleware' => ['web', 'auth', 'locale'],
        'prefix' => 'configuration/prices-core',
    ], function () {
        Route::get('/settings')
            ->name('pricescore::settings')
            ->uses('SettingsController@view')
            ->middleware('can:pricescore.settings');

        Route::get('/instance/new')
            ->name('pricescore::instance.new')
            ->uses('SettingsController@newInstance')
            ->middleware('can:pricescore.settings');

        Route::post('/instance/new')
            ->name('pricescore::instance.new.post')
            ->uses('SettingsController@newInstancePost')
            ->middleware('can:pricescore.settings');
    });
});