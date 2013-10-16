<?php

namespace ShopStyle\Iterator;


use Guzzle\Service\Command\CommandInterface;
use Guzzle\Service\Resource\Model;
use Guzzle\Service\Resource\ResourceIterator;

class GetProductsIterator extends ResourceIterator
{

    /**
     * {@inheritdoc}
     */
    public function __construct(CommandInterface $command, array $data = array())
    {
        parent::__construct($command, $data);
        if (!$this->pageSize) {
            $this->pageSize = $command->get('limit') ? : 10;
        }
    }


    /**
     * Send a request to retrieve results.
     *
     * @return array Returns the newly loaded resources
     */
    protected function sendRequest()
    {
        // Prepare the request including setting the next token
        $pageSize = $this->calculatePageSize();
        $this->command->set('limit', $pageSize);
        if ($this->nextToken) {
            $this->command->set('offset', $this->nextToken);
        }

        // Execute the command and parse the result
        /** @var Model $result */
        $result = $this->command->getResult();
        $this->nextToken = $result->getPath('metadata/offset') + $pageSize;

        return $result['products'] ? : array();
    }
}
