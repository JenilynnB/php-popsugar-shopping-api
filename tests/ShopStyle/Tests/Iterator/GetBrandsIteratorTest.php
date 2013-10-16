<?php

namespace ShopStyle\Tests\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;
use ShopStyle\Iterator\GetBrandsIterator;

/**
 * @covers ShopStyle\Iterator\GetBrandsIterator
 */
class GetBrandsIteratorTest extends AbstractIteratorTest
{
    protected function getTestData()
    {
        return array(
            'brands' =>
                array(
                    0 =>
                        array(
                            'id' => '1',
                            'name' => '213 Industry',
                            'url' => 'http://www.shopstyle.com/browse/213-Industry?pid=test-pid',
                            'synonyms' =>
                                array(),
                        ),
                    1 =>
                        array(
                            'id' => '3',
                            'name' => '7 For All Mankind',
                            'url' => 'http://www.shopstyle.com/browse/7-For-All-Mankind?pid=test-pid',
                            'synonyms' =>
                                array(
                                    0 => 'For All Mankind',
                                    1 => 'Seven7',
                                    2 => 'Seven Jeans',
                                    3 => '7 Jeans',
                                    4 => 'Seven7 Jeans',
                                    5 => 'Seven For All Mankind',
                                ),
                        ),
                    2 =>
                        array(
                            'id' => '4',
                            'name' => 'A. Marinelli',
                            'url' => 'http://www.shopstyle.com/browse/A.-Marinelli?pid=test-pid',
                            'synonyms' =>
                                array(),
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
        return new GetBrandsIterator($command);
    }

    /**
     * @return array
     */
    protected function getExpectedData()
    {
        $expected = $this->getTestData();
        return $expected['brands'];
    }
}
