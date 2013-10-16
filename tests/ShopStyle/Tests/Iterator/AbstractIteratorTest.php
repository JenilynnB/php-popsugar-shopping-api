<?php

namespace ShopStyle\Tests\Iterator;

use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\Model;
use Guzzle\Service\Resource\ResourceIterator;
use Guzzle\Tests\GuzzleTestCase;

abstract class AbstractIteratorTest extends GuzzleTestCase
{

    /**
     * @param CommandInterface $command
     * @return ResourceIterator
     */
    abstract protected function getIterator(CommandInterface $command);

    /**
     * @return array
     */
    abstract protected function getTestData();

    /**
     * @return array
     */
    abstract protected function getExpectedData();

    public function testResultHandlingWorks()
    {
        // Prepare an iterator
        $command = $this->getMock('Guzzle\Service\Command\CommandInterface');
        $iterator = $this->getIterator($command);
        $model = new Model($this->getTestData());

        $command
            ->expects($this->once())
            ->method('execute')
            ->will($this->returnValue($model));

        $items = $iterator->toArray();

        $this->assertSame($this->getExpectedData(), $items);
    }
}
