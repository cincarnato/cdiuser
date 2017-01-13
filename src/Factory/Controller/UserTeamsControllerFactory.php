<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\UserTeamsController;

class UserTeamsControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $moduleOptions = $container->get('cdiuser_module_options');

        $em = $container->get('Doctrine\ORM\EntityManager');

        /* @var $grid \CdiUser\Form\TeamUsers */
        $form = $container->build(\CdiUser\Form\UserTeams::class);

        $userId = $container->get('Application')->getMvcEvent()->getRouteMatch()->getParam('userId', false);

        $user = $em->getRepository("\CdiUser\Entity\User")->find($userId);

        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($em, 'CdiUser\Entity\User'))
                ->setObject($user);


        return new UserTeamsController($em, $form, $user,$moduleOptions);
    }

}
