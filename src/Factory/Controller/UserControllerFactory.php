<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\UserController;

class UserControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        //$options = $container->get('cdiuser_module_options');

        $em = $container->get('Doctrine\ORM\EntityManager');
        $lpassForm = $container->get(\CdiUser\Form\LostPasswordForm::class);
         $options = $container->get('cdiuser_module_options');
          $zfcUserOptions = $container->get('zfcuser_module_options');
        
        return new UserController($em, $lpassForm,$options,$zfcUserOptions);
    }

}
