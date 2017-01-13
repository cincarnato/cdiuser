<?php

namespace CdiUser\Factory\Controller;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use CdiUser\Controller\UserLogDetailController;

class UserLogDetailControllerFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {
    
        $options = $container->get('cdiuser_module_options');
      
        //ADD CDIDATAGRID
        /* @var $grid \CdiDataGrid\Grid */
        $grid = $container->build("CdiDatagrid", ["customOptionsKey" => "cdiDataGridUserLogDetail"]);

        return new UserLogDetailController($grid, $options);
    }

}
