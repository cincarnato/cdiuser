<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\UserController;

class GroupUsersControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $moduleOptions = $container->get('cdiuser_module_options');

        $em = $container->get('Doctrine\ORM\EntityManager');

        /* @var $grid \CdiUser\Form\GroupUsers */
        $form = $container->build(\CdiUser\Form\GroupUsers::class);


        return new UserController($em, $form, $moduleOptions);
    }

}
