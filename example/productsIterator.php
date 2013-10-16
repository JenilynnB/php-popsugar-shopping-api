<?php


use Guzzle\Service\Resource\ResourceIterator;
use ShopStyle\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = Client::factory(
    array(
        'pid' => 'sugar',
        'host' => 'api.shopstyle.com' //optional
    )
);

$commandArgs = array(
    'fl' => array(
        array('brand' => '3510'),
        array('retailer' => '21'),
    ),
    'freeTextSearch' => 'Halter'
);

$iteratorArgs = array(
    'limit' => 10,
    'page_size' => 10
);

/** @var ResourceIterator $productsIterator */
$productsIterator = $client->getProductsIterator($commandArgs, $iteratorArgs);
foreach ($productsIterator as $product) {
    echo $product['name'], PHP_EOL;
}
