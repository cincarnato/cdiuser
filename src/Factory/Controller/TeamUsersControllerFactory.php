<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\TeamUsersController;

class TeamUsersControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $moduleOptions = $container->get('cdiuser_module_options');

        $em = $container->get('Doctrine\ORM\EntityManager');

        /* @var $grid \CdiUser\Form\TeamUsers */
        $form = $container->build(\CdiUser\Form\TeamUsers::class);

        $teamId = $container->get('Application')->getMvcEvent()->getRouteMatch()->getParam('teamId', false);

        $team = $em->getRepository("\CdiUser\Entity\Team")->find($teamId);

        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($em, 'CdiUser\Entity\Team'))
                ->setObject($team);


        return new TeamUsersController($em, $form, $team,$moduleOptions);
    }

}
