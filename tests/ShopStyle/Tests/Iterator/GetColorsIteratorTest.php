<?php

namespace ShopStyle\Tests\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;
use ShopStyle\Iterator\GetColorsIterator;

/**
 * @covers ShopStyle\Iterator\GetColorsIterator
 */
class GetColorsIteratorTest extends AbstractIteratorTest
{
    protected function getTestData()
    {
        return array(
            'colors' =>
                array(
                    0 =>
                        array(
                            'id' => '1',
                            'name' => 'Brown',
                            'url' => 'http://www.shopstyle.com/browse?fl=c1&pid=uid2916-7802554-40',
                        ),
                    1 =>
                        array(
                            'id' => '3',
                            'name' => 'Orange',
                            'url' => 'http://www.shopstyle.com/browse?fl=c3&pid=uid2916-7802554-40',
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
        return new GetColorsIterator($command);
    }

    /**
     * @return array
     */
    protected function getExpectedData()
    {
        $expected = $this->getTestData();
        return $expected['colors'];
    }
}
