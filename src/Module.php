<?php

declare(strict_types=1);

namespace NewRelic;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\Loader\StandardAutoloader;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig(): array
    {
        return [
            StandardAutoloader::class => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function onBootstrap(MvcEvent $e): void
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $client = $serviceManager->get(Client::class);
        if (!$client->extensionLoaded()) {
            return;
        }

        /* @var $eventManager \Zend\EventManager\EventManager */
        $eventManager = $application->getEventManager();

        $moduleOptions = $serviceManager->get(ModuleOptions::class);
        foreach ($moduleOptions->getListeners() as $service) {
            /** @var ListenerAggregateInterface $listener */
            $listener = $serviceManager->get($service);
            $listener->attach($eventManager);
        }
    }
}
