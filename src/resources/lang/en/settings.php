<?php

return [
    'price_provider_instance' => 'Price Provider Instance|Price Provider Instances',
    'price_provider_settings' => 'Price Provider Settings',
    'price_provider'          => 'Price Provider|Price Providers',
    'unknown_plugin'          => 'Unknown Plugin',
    'new'                     => 'New',
    'new_price_provider_instance' => 'New Price Provider Instance',
    'back'                        => 'Back',
    'price_provider_type'         => 'Price Provider Type',
    'name_placeholder'            => 'Enter a name',
    'name'                        => 'Name',
    'next'                        => 'Next',
    'unknown_price_provider_type' => ' Unknown price provider type \':type\'.',
    'misconfigured_plugin_info'   => 'The price provider configuration for \':price_provider\' from \':plugin\' has an error (missing \'settings_route\'). Please report this bug to the developer.',
    'instance_delete_success'     => 'Successfully deleted price provider instance.',
    'instance_not_found'          => 'Price provider instance not found!',
    'price_provider_backend_not_found'    => 'Price provider backend \':backend\' not found in price provider backend registry. Has a plugin been uninstalled?',
    'price_provider_backend_impl_missing' => 'Backend configuration for \':backend\' is missing a \'backend\' property',
    'price_provider_backend_no_backend'   => 'Backend configuration for \':backend\' specifies a backend implementation that doesn\'t implement \':class\'.',
    'instructions_title' => 'Instructions',
    'instructions'       => 'On this page, you can configure the settings of price provider instances used in plugins. A price provider instance is a price provider (a source of price information) combined with its configuration, like which market to use or whether to use sell or buy prices. You have to create and configure the price provider instances on this page to use them in plugins. Plugins using the price provider system should have a setting to select a price provider in their settings.',
    'price_provider_instance_not_fount' => 'The requested price provider instance not found. Has it been deleted in the settings?'
];