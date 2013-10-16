<?php

use ShopStyle\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = Client::factory(
    array(
        'pid' => 'sugar',
        'host' => 'api.shopstyle.com' //optional
    )
);

$retailers = $client->getRetailersIterator(array(), array('limit' => 20));

foreach ($retailers as $retailer) {
    echo $retailer['name'], PHP_EOL;
}
