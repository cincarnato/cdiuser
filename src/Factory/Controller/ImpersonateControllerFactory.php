<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\ImpersonateController;

class ImpersonateControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $options = $container->get('cdiuser_module_options');
        $userService = $container->get('cdiuser_impersonate_user_service');

        return new ImpersonateController($options,$userService);
    }

}
