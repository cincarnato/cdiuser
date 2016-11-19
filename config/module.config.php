<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

$setting = array(
    'zfcuser' => require __DIR__ . '/zfcuser.config.php',
    'zfc_rbac' => require __DIR__ . '/zfc_rbac.config.php',
    'cdiuser' => array(
        'user_mapper' => 'CdiUser\Mapper\UserDoctrine',
        'allow_password_change' => true,
        'create_user_auto_password' => false,
        "mail" => [
            "message" => [
                "fromMail" => "info@perfilit.com.ar",
                "fromName" => "LP"
            ],
            "transport" => [
                "smtp" => "127.0.0.1",
            ]
        ]
    ),
    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiUser\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cdiuser' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cdiuser' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/user',
                    'defaults' => array(
                        'controller' => 'cdiuseradmin',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'list' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/list',
                            'defaults' => array(
                                'controller' => 'cdiuseradmin',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'cdiuseradmin',
                                'action' => 'create'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:userId',
                            'defaults' => array(
                                'controller' => 'cdiuseradmin',
                                'action' => 'edit',
                                'userId' => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:userId',
                            'defaults' => array(
                                'controller' => 'cdiuseradmin',
                                'action' => 'remove',
                                'userId' => 0
                            ),
                        ),
                    ),
                ),
            ),
            'cdiuserlpass' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/lpass',
                    'defaults' => array(
                        'controller' => 'cdiuser',
                        'action' => 'lpass',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'admin' => array(
            'cdiuser' => array(
                'label' => 'Users',
                'route' => 'cdiuser/list',
                'pages' => array(
                    'create' => array(
                        'label' => 'New User',
                        'route' => 'cdiuseradmin/create',
                    ),
                ),
            ),
        ),
    ),
);


$cdiDatagridCustomConfig = include 'cdi-datagrid-custom.config.php';

$setting = array_merge($setting, $cdiDatagridCustomConfig);

return $setting;
