<?php

namespace CdiUser\Factory\Listener;


use Interop\Container\ContainerInterface;
use CdiUser\Listener\RbacListener;
use Zend\ServiceManager\Factory\FactoryInterface;

class RbacListenerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
    
        $authorizationService = $container->get('ZfcRbac\Service\AuthorizationService');

        return new RbacListener($authorizationService);
    }
}
