<?php

use Interop\Container\ContainerInterface;

return array(
    'invokables' => array(
        'CdiUser\Form\EditUser' => 'CdiUser\Form\EditUser',
        'cdiuser_user_service' => 'CdiUser\Service\User',
    ),
    'factories' => array(
        'cdiuser_module_options' => function (ContainerInterface $container) {
            $config = $container->get('Config');
            return new \CdiUser\Options\ModuleOptions(isset($config['cdiuser']) ? $config['cdiuser'] : array());
        },
                'cdiuser_edituser_form' => \CdiUser\Factory\Form\EditUserFactory::class
                ,
                'cdiuser_createuser_form' => \CdiUser\Factory\Form\CreateUserFactory::class
                ,
                'zfcuser_user_mapper' => \CdiUser\Factory\UserMapperFactory::class
            ),
        );





        
