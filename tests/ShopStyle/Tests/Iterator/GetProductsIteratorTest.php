<?php

namespace ShopStyle\Tests\Iterator;

use Guzzle\Tests\GuzzleTestCase;
use Guzzle\Tests\Service\Mock\Command\MockCommand;
use ShopStyle\Iterator\GetProductsIterator;

/**
 * @covers ShopStyle\Iterator\GetProductsIterator
 */
class GetProductsIteratorTest extends GuzzleTestCase
{
    public function testDefaultPageSizeSet()
    {
        $testSize = 5;
        // Prepare an iterator
        $command = new MockCommand(array('limit' => $testSize));

        $iterator = new GetProductsIterator($command);
        $reflection = new \ReflectionObject($iterator);
        $property = $reflection->getProperty('pageSize');
        $property->setAccessible(true);
        $value = $property->getValue($iterator);

        $this->assertEquals($testSize, $value, 'Products Iterator did not set default page size value');
    }

    public function testIterator3Requests()
    {
        /** @var \ShopStyle\Client $client */
        $client = $this->getServiceBuilder()->get('mock', true);
        $mock = $this->setMockResponse(
            $client,
            array(
                'get_products_iterator_page1',
                'get_products_iterator_page2',
                'get_products_iterator_page3',
            )
        );

        /** @var GetProductsIterator $iterator */
        $iterator = $client->getProductsIterator(array(), array('page_size' => 3, 'limit' => 8));

        $this->assertEquals(8, iterator_count($iterator));

        /** @var \Guzzle\Http\Message\Request[] $requests */
        $requests = $mock->getReceivedRequests();
        $this->assertEquals(3, count($requests));

        $this->assertEquals(3, $requests[0]->getQuery()->get('limit'));
        $this->assertEquals(0, $requests[0]->getQuery()->get('offset'));

        $this->assertEquals(3, $requests[1]->getQuery()->get('limit'));
        $this->assertEquals(3, $requests[1]->getQuery()->get('offset'));

        $this->assertEquals(2, $requests[2]->getQuery()->get('limit'));
        $this->assertEquals(6, $requests[2]->getQuery()->get('offset'));
    }

    public function testIteratorLimited()
    {
        /** @var \ShopStyle\Client $client */
        $client = $this->getServiceBuilder()->get('mock', true);
        $mock = $this->setMockResponse(
            $client,
            array(
                'get_products_iterator_page1',
                'get_products_iterator_page2',
                'get_products_iterator_page3',
            )
        );

        /** @var GetProductsIterator $iterator */
        $iterator = $client->getProductsIterator(array(), array('page_size' => 3, 'limit' => 5));

        $this->assertEquals(5, iterator_count($iterator));

        /** @var \Guzzle\Http\Message\Request[] $requests */
        $requests = $mock->getReceivedRequests();
        $this->assertEquals(2, count($requests));

        $this->assertEquals(3, $requests[0]->getQuery()->get('limit'));
        $this->assertEquals(0, $requests[0]->getQuery()->get('offset'));

        $this->assertEquals(2, $requests[1]->getQuery()->get('limit'));
        $this->assertEquals(3, $requests[1]->getQuery()->get('offset'));
    }
}
