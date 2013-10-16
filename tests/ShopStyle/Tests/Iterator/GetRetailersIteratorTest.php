<?php

namespace ShopStyle\Tests\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;
use ShopStyle\Iterator\GetRetailersIterator;

/**
 * @covers ShopStyle\Iterator\GetRetailersIterator
 */
class GetRetailersIteratorTest extends AbstractIteratorTest
{
    protected function getTestData()
    {
        return array(
            'retailers' =>
                array(
                    0 =>
                        array(
                            'id' => '1',
                            'name' => 'Nordstrom',
                            'url' => 'http://www.shopstyle.com/browse/Nordstrom-US?pid=uid2916-7802554-40',
                            'deeplinkSupport' => true,
                        ),
                    1 =>
                        array(
                            'id' => '2',
                            'name' => 'Macy\'s',
                            'url' => 'http://www.shopstyle.com/browse/Macys-US?pid=uid2916-7802554-40',
                            'deeplinkSupport' => true,
                        ),
                ),
        );
    }

    /**
     * @param CommandInterface $command
     * @return ResourceIterator
     */
    protected function getIterator(CommandInterface $command)
    {
        return new GetRetailersIterator($command);
    }

    /**
     * @return array
     */
    protected function getExpectedData()
    {
        $expected = $this->getTestData();
        return $expected['retailers'];
    }
}
