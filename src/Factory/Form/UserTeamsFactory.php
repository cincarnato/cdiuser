<?php

namespace CdiUser\Factory\Form;

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserTeamsFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) {

        $em = $container->get('doctrine.entitymanager.orm_default');

        $form = new \CdiUser\Form\UserTeams($em);

        return $form;
    }

}