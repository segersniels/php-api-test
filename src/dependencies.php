<?php

require __DIR__ . '/../includes/api.php';

// DIC configuration
$container = $app->getContainer();

// api
$container['api'] = function ($c) {
    $settings = $c->get('settings');
    $api = new API($settings);
    return $api;
};
