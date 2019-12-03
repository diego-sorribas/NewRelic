<?php
namespace NewRelic\Listener;

use NewRelic\ClientInterface;
use NewRelic\ModuleOptionsInterface;
use NewRelic\TransactionMatcher;
use Zend\Mvc\MvcEvent;

abstract class AbstractTransactionListener extends AbstractListener
{
    /**
     * @var TransactionMatcher
     */
    protected $transactionMatcher;

    public function __construct(
        ClientInterface $client,
        ModuleOptionsInterface $options,
        TransactionMatcher $transactionMatcher
    ) {
        parent::__construct($client, $options);
        $this->transactionMatcher = $transactionMatcher;
    }

    protected function isMatchedRequest(MvcEvent $e): bool
    {
        return $this->transactionMatcher->isMatched($e);
    }
}
