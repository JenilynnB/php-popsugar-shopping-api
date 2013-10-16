<?php

use ShopStyle\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = Client::factory(
    array(
        'pid' => 'sugar',
        'host' => 'api.shopstyle.com' //optional
    )
);

$retailers = $client->getRetailers();

foreach ($retailers['retailers'] as $retailer) {
    echo $retailer['name'], PHP_EOL;
}
