<?php


use ShopStyle\Client;

require __DIR__ . '/../vendor/autoload.php';

$client = Client::factory(
    array(
        'pid' => 'sugar', // required
        'host' => 'api.shopstyle.com' // optional
    )
);

$args = [
    'fl' => array(
        array('brand' => '3510'),
        array('retailer' => '1'),
        array('retailer' => '2'),
    ),
    'category' => 'dresses',
    'freeTextSearch' => 'Sweater'
];

$res = $client->getBrandHistogram($args);
$brandsUrls = $res->getPath('brandHistogram/*/url');
var_dump($brandsUrls);
