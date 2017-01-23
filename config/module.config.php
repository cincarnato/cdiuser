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
        'edit_form_elements' => ["displayName" => "displayName"],
        'create_form_elements' => ["displayName" => "displayName"],
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
            'cdiuser_admin' => array(
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
                    'teams' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/teams/:userId',
                            'defaults' => array(
                                'controller' => 'cdiuserteams',
                                'action' => 'teams',
                            ),
                        ),
                    ),
                    'log' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/log',
                            'defaults' => array(
                                'controller' => 'cdiuserlog',
                                'action' => 'log',
                            ),
                        ),
                    ),
                    'logdetail' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/log-detail',
                            'defaults' => array(
                                'controller' => 'cdiuserlogdetail',
                                'action' => 'log',
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
            'cdiuser_admin_teams' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/team',
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
                                'controller' => 'cditeam',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'users' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/users/:teamId',
                            'defaults' => array(
                                'controller' => 'cditeamusers',
                                'action' => 'users',
                            ),
                        ),
                    ),
                ),
            ),
            'cdiuser_lpass' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/lpass',
                    'defaults' => array(
                        'controller' => 'cdiuser',
                        'action' => 'lpass',
                    ),
                ),
            ),
            'cdiuser_log_in' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/log/in',
                    'defaults' => array(
                        'controller' => 'cdiuser',
                        'action' => 'login',
                    ),
                ),
            ),
            'cdiuser_log_out' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/log/out',
                    'defaults' => array(
                        'controller' => 'cdiuser',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format' => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string' => '</li></ul></div>',
            'message_separator_string' => '</li><li>'
        )
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
