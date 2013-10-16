<?php

namespace ShopStyle\Tests\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\ResourceIterator;
use ShopStyle\Iterator\GetCategoriesIterator;

/**
 * @covers ShopStyle\Iterator\GetCategoriesIterator
 */
class GetCategoriesIteratorTest extends AbstractIteratorTest
{
    protected function getTestData()
    {
        return array(
            'metadata' =>
                array(
                    'root' =>
                        array(
                            'id' => 'clothes-shoes-and-jewelry',
                            'name' => 'Clothes and Shoes',
                        ),
                    'maxDepth' => 20,
                ),
            'categories' =>
                array(
                    0 =>
                        array(
                            'id' => 'women',
                            'name' => 'Women\'s Fashion',
                            'parentId' => 'clothes-shoes-and-jewelry',
                        ),
                    1 =>
                        array(
                            'id' => 'womens-clothes',
                            'name' => 'Clothing',
                            'parentId' => 'women',
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
        return new GetCategoriesIterator($command);
    }

    /**
     * @return array
     */
    protected function getExpectedData()
    {
        $expected = $this->getTestData();
        return $expected['categories'];
    }
}
