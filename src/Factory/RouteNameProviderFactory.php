<?php

declare(strict_types=1);

namespace NewRelic\Factory;

use NewRelic\Client;
use NewRelic\ModuleOptions;
use NewRelic\TransactionNameProvider\RouteNameProvider;
use Psr\Container\ContainerInterface;
use NewRelic\Listener\ResponseListener;

class RouteNameProviderFactory
{
    public function __invoke(ContainerInterface $container): RouteNameProvider
    {
        $client = $container->get(Client::class);
        $options = $container->get(ModuleOptions::class);

        return new RouteNameProvider($client, $options);
    }
}
