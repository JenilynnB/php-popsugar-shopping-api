<?php
error_reporting(-1);

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . '/composer.lock')) {
    die("Dependencies must be installed using composer:\n\nphp composer.phar install\n\n"
        . "See http://getcomposer.org for help with installing composer\n");
}

// Include the composer autoloader
$loader = require dirname(__DIR__) . '/vendor/autoload.php';

// Register services with the GuzzleTestCase
Guzzle\Tests\GuzzleTestCase::setMockBasePath(__DIR__ . '/mock');

// Instantiate the service builder
$serviceBuilder = Guzzle\Service\Builder\ServiceBuilder::factory(
    array(
        'mock' => array(
            'class' => '\ShopStyle\Client',
            'params' => array(
                'pid' => 'mock',
                'api_host' => 'example.com',
            )
        )
    )
);

// Use our service builder
Guzzle\Tests\GuzzleTestCase::setServiceBuilder($serviceBuilder);

// Emit deprecation warnings
Guzzle\Common\Version::$emitWarnings = true;
