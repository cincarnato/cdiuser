<?php

namespace CdiUser\Factory\View\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\View\Helper\Impersonate;

class ImpersonateFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $userService = $container->get('cdiuser_impersonate_user_service');

        return new Impersonate($userService);
    }

}
