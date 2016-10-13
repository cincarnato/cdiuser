<?php

namespace CdiUser\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Service\User;

class UserFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
    {
        $userMapper = $container->get('zfcuser_user_mapper');
        $cdiUserOptions = $container->get('cdiuser_module_options');
        $zfcUserOptions = $container->get('zfcuser_module_options');
        
        return new User($userMapper, $cdiUserOptions, $zfcUserOptions);
    }


}
