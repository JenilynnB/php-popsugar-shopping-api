<?php

namespace ShopStyle\Tests;

use Guzzle\Tests\GuzzleTestCase;
use ShopStyle\Filter\ProductQueryFilter;

/**
 * @covers ShopStyle\Filter\ProductQueryFilter
 */
class ProductQueryFilterTest extends GuzzleTestCase
{
    public function testConvertFilterItemWithMapping()
    {
        $filters = array(
            array('brand' => 10),
            array('retailer' => 20),
            array('sale' => 30),
        );
        $expected = array('b10', 'r20', 'd30');

        $this->assertEquals($expected, ProductQueryFilter::convertFilterItem($filters));
    }

    public function testConvertFilterItemWithoutMapping()
    {
        $filters = array(
            array('coffee' => 10),
            array('a' => 20),
        );
        $expected = array('coffee10', 'a20');

        $this->assertEquals($expected, ProductQueryFilter::convertFilterItem($filters));
    }
}
