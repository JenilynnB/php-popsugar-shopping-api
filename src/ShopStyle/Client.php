<?php

namespace ShopStyle;


use Guzzle\Common\Collection;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\QueryAggregator\DuplicateAggregator;
use Guzzle\Service\Client as GuzzleClient;
use Guzzle\Service\Description\ServiceDescription;
use Guzzle\Service\Resource\Model;
use Guzzle\Service\Resource\ResourceIteratorInterface;

/**
 * Class Client
 * @package ShopStyle
 *
 * @api
 *
 * @see https://shopsense.shopstyle.com/shopsense/7234197
 *
 * @method Model getRetailers(array $args = array())
 * @method Model getBrands(array $args = array())
 * @method Model getCategories(array $args = array())
 * @method Model getColors(array $args = array())
 * @method Model getHistogram(array $args = array())
 * @method Model getCategoryHistogram(array $args = array())
 * @method Model getBrandHistogram(array $args = array())
 * @method Model getRetailerHistogram(array $args = array())
 * @method Model getPriceHistogram(array $args = array())
 * @method Model getDiscountHistogram(array $args = array())
 * @method Model getSizeHistogram(array $args = array())
 * @method Model getColorHistogram(array $args = array())
 * @method Model getProducts(array $args = array())
 *
 * @method ResourceIteratorInterface getBrandsIterator(array $commandArgs = array(), array $iteratorArgs = array()) The input array uses the parameters of the getBrands operation
 * @method ResourceIteratorInterface getCategoriesIterator(array $commandArgs = array(), array $iteratorArgs = array()) The input array uses the parameters of the getCategories operation
 * @method ResourceIteratorInterface getColorsIterator(array $commandArgs = array(), array $iteratorArgs = array()) The input array uses the parameters of the getColors operation
 * @method ResourceIteratorInterface getProductsIterator(array $commandArgs = array(), array $iteratorArgs = array()) The input array uses the parameters of the getProducts operation
 * @method ResourceIteratorInterface getRetailersIterator(array $commandArgs = array(), array $iteratorArgs = array()) The input array uses the parameters of the getRetailers operation
 */
class Client extends GuzzleClient
{

    /**
     * Factory method to create a new Shopstyle API Client
     *
     * The following array keys and values are available options:
     * - base_url:            Base URL of web service
     * - version:             API version
     * - pid:                 Shopstyle API ID
     * - service_definition:  Full path to guzzle service definition file
     *
     *
     * @param array|Collection $config Configuration data
     *
     * @return self
     */
    public static function factory($config = array())
    {
        $config = self::processConfig($config);

        $client = new self($config->get('base_url'), $config);

        $client->setDescription(
            ServiceDescription::factory($config->get('service_definition'))
        );

        return $client;
    }

    private static function processConfig($config = array())
    {
        $defaults = array(
            'base_url' => 'http://{api_host}/api/{api_version}',
            'api_host' => 'api.shopstyle.com',
            'api_version' => 'v2',
            'service_definition' => __DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'client.json'
        );

        $required = array('pid');

        return Collection::fromConfig($config, $defaults, $required);
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest(
        $method = RequestInterface::GET,
        $uri = null,
        $headers = null,
        $body = null,
        array $options = array()
    ) {
        $request = parent::createRequest($method, $uri, $headers, $body, $options);

        $query = $request->getQuery();
        $query->set('pid', $this->getConfig()->get('pid'));
        $query->setAggregator(new DuplicateAggregator());

        return $request;
    }

    /**
     * Return product description
     *
     * @param $productId integer Product ID
     * @return Model
     */
    public function getProduct($productId)
    {
        return $this->getCommand('GetProduct', array('prodid' => $productId))->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, $args)
    {
        if (substr($method, 0, 3) === 'get' && substr($method, -8) === 'Iterator') {
            // Allow magic method calls for iterators (e.g. $client->get<CommandName>Iterator($params))
            $commandOptions = isset($args[0]) ? $args[0] : null;
            $iteratorOptions = isset($args[1]) ? $args[1] : array();
            return $this->getIterator(ucfirst(substr($method, 0, -8)), $commandOptions, $iteratorOptions);
        }

        return parent::__call(ucfirst($method), $args);
    }
}
