<?php

namespace ShopStyle\Tests;

use Guzzle\Tests\GuzzleTestCase;
use ShopStyle\Client;

/**
 * @covers ShopStyle\Client
 */
class ShopStyleClientTest extends GuzzleTestCase
{
    public function testFactoryInitializesClient()
    {
        $client = Client::factory(
            array(
                'pid' => 'foo',
                'api_host' => 'api.something.com',
                'api_version' => 'v999'
            )
        );

        $this->assertEquals('http://api.something.com/api/v999', $client->getBaseUrl());
    }

    public function testFactoryInitializesClientThrowsExceptionOnNoPid()
    {
        $this->setExpectedException('Guzzle\Common\Exception\InvalidArgumentException');
        Client::factory(
            array(
                'api_host' => 'api.something.com'
            )
        );
    }

    public function testQueryStringHasPid()
    {
        $client = $this->getServiceBuilder()->get('mock');

        $query = $client->createRequest()->getQuery();
        $query->replace(
            array(
                'test' => array(1, 2, 3)
            )
        );

        $this->assertEquals('test=1&test=2&test=3', (string)$query);
    }

    public function testBuiltQueryStringHasCorrectFormat()
    {
        $pid = 'foo';
        $client = Client::factory(array('pid' => $pid));

        $query = $client->createRequest()->getQuery();

        $this->assertEquals($pid, $query->get('pid'));
    }

    public function testClientUpperCasesMagicMethodCallsToCommands()
    {
        /** @var $client \ShopStyle\Client */
        $client = $this->getServiceBuilder()->get('mock');

        $factory = $this->getMockBuilder('Guzzle\Service\Command\Factory\FactoryInterface')
            ->getMock();

        $factory->expects($this->once())
            ->method('factory')
            ->with('FooBar')
            ->will($this->returnValue(null));

        $client->setCommandFactory($factory);

        try {
            $client->fooBar();
        } catch (\Exception $e) {}
    }

    public function testAllowsMagicIterators()
    {
        $client = $this->getMockBuilder('ShopStyle\Client')
            ->disableOriginalConstructor()
            ->setMethods(array('getIterator'))
            ->getMock();

        $client->expects($this->once())
            ->method('getIterator')
            ->with('GetFoo', array('baz' => 'bar'));
        $client->getFooIterator(array('baz' => 'bar'));
    }

    public function testGetProductCommand()
    {
        $prodId = 100500;

        /** @var $client \ShopStyle\Client */
        $client = $this->getServiceBuilder()->get('mock');

        $factory = $this->getMockBuilder('Guzzle\Service\Command\Factory\FactoryInterface')
            ->getMock();

        $factory->expects($this->once())
            ->method('factory')
            ->with('GetProduct', array('prodid' => $prodId))
            ->will($this->returnValue(null));

        $client->setCommandFactory($factory);

        try {
            $client->getProduct($prodId);
        } catch (\Exception $e) {
        }
    }
}
