<?php

namespace ShopStyle\Iterator;


use Guzzle\Service\Resource\ResourceIterator;

class GetRetailersIterator extends ResourceIterator
{

    /**
     * Send a request to retrieve results.
     *
     * @return array Returns the newly loaded resources
     */
    protected function sendRequest()
    {
        // Execute the command and parse the result
        $result = $this->command->execute();

        return $result['retailers'] ? : array();
    }
}
