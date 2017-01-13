<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\TeamController;

class TeamControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        //$options = $container->get('cdiuser_module_options');

        $em = $container->get('Doctrine\ORM\EntityManager');

        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid", ["customOptionsKey" => "cdiDataGridTeam"]);

        $moduleOptions = $container->get('cdiuser_module_options');
        $zfcUserOptions = $container->get('zfcuser_module_options');

        return new TeamController($em, $grid, $moduleOptions, $zfcUserOptions);
    }

}
