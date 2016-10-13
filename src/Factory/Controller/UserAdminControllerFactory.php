<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\UserAdminController;

class UserAdminControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
        $createUserForm = $container->get('CreateUserForm');
        $editUserForm = $container->get('EditUserForm');
        $options = $container->get('cdiuser_module_options');
        $userMapper = $container->get('zfcuser_user_mapper');
        $adminUserService = $container->get('cdiuser_user_service');
        $zfcUserOptions = $container->get('zfcuser_module_options');
        return new UserAdminController(
                $createUserForm, $editUserForm, $options, $userMapper, $adminUserService, $zfcUserOptions
        );
    }

}
