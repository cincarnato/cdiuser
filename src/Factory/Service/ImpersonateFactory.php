<?php

namespace CdiUser\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Service\Impersonate;
use Zend\Authentication\Storage\Session;

class ImpersonateFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $userMapper = $container->get('zfcuser_user_mapper');
        $cdiUserOptions = $container->get('cdiuser_module_options');
        
        $service = new Impersonate();
        $service->setServiceManager($container);
        $service->setCdiUserOptions($cdiUserOptions);
        $service->setStorageForImpersonator(new Session(get_class($service), 'impersonator'));
        $service->setStoreUserAsObject($container->get('cdiuser_module_options')->getStoreUserAsObject());
        return $service;
    }


}
