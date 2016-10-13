<?php

use Interop\Container\ContainerInterface;

return array(
    'factories' => array(
        'cdiuser_module_options' => function (ContainerInterface $container) {
            $config = $container->get('Config');
            return new \CdiUser\Options\ModuleOptions(isset($config['cdiuser']) ? $config['cdiuser'] : array());
        },
                'EditUserForm' => \CdiUser\Factory\Form\EditUserFactory::class,
                'CreateUserForm' => \CdiUser\Factory\Form\CreateUserFactory::class,
                'cdiuser_user_service' => \CdiUser\Factory\Service\UserFactory::class,
                'zfcuser_user_mapper' => \CdiUser\Factory\Mapper\UserMapperFactory::class,
            ),
        );







        
