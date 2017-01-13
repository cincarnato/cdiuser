<?php

use Interop\Container\ContainerInterface;

return [
    'aliases' => [
        'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service'
    ],
    'factories' => [
        'CdiUser\Listener\RbacListener' => 'CdiUser\Factory\Listener\RbacListenerFactory',
        'cdiuser_module_options' => function (ContainerInterface $container) {
            $config = $container->get('Config');
            return new \CdiUser\Options\ModuleOptions(isset($config['cdiuser']) ? $config['cdiuser'] : array());
        },
                CdiUser\Form\EditUserForm::class => \CdiUser\Factory\Form\EditUserFactory::class,
                CdiUser\Form\CreateUserForm::class => \CdiUser\Factory\Form\CreateUserFactory::class,
                CdiUser\Form\LostPasswordForm::class => \CdiUser\Factory\Form\LostPasswordFactory::class,
                CdiUser\Form\TeamUsers::class => \CdiUser\Factory\Form\TeamUsersFactory::class,
                 CdiUser\Form\UserTeams::class => \CdiUser\Factory\Form\UserTeamsFactory::class,
                'cdiuser_user_service' => \CdiUser\Factory\Service\UserFactory::class,
                'zfcuser_user_mapper' => \CdiUser\Factory\Mapper\UserMapperFactory::class,
            ],
        ];








        
