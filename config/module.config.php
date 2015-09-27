<?php

return array(
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CdiUser/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiUser\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class' => 'CdiUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
        'enable_registration' => false,
        'enable_username' => true,
        'auth_identity_fields' => array('email', 'username'),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'zfcuseradmin' => __DIR__ . '/../view',
            'cdiuser' => __DIR__ . '/../view',
        ),
    ),
    'cdiuser_options' => array(
        'register_session' => true,
        'session_life_time' => 122,
        'keepalive' => 120,
    ),
    'controllers' => array(
        'invokables' => array(
            'zfcuseradmin' => 'CdiUser\Controller\UserAdminController',
            'usersession' => 'CdiUser\Controller\UserSessionController',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'JsKeepalive' => 'CdiUser\View\Helper\JsKeepalive', //Need JavaScript and JQuery
        )
    ),
    'router' => array(
        'routes' => array(
            'cdiuser' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/cdiuser',
                    'defaults' => array(
                        'controller' => 'usersession',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'keepalive' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/keepalive',
                            'defaults' => array(
                                'controller' => 'usersession',
                                'action' => 'keepalive',
                            ),
                        ),
                    ),
                ),
            ),
            'zfcadmin' => array(
                'child_routes' => array(
                    'zfcuseradmin' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/user',
                            'defaults' => array(
                                'controller' => 'zfcuseradmin',
                                'action' => 'index',
                            ),
                        ),
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/list[/:p]',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                            'create' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/create',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
                                        'action' => 'create'
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:userId',
                                    'defaults' => array(
                                        'controller' => 'zfcuseradmin',
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
                                        'controller' => 'zfcuseradmin',
                                        'action' => 'remove',
                                        'userId' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'admin' => array(
            'zfcuseradmin' => array(
                'label' => 'Users',
                'route' => 'zfcadmin/zfcuseradmin/list',
                'pages' => array(
                    'create' => array(
                        'label' => 'New User',
                        'route' => 'zfcadmin/zfcuseradmin/create',
                    ),
                ),
            ),
        ),
    ),
    'zfcuseradmin' => array(
        'zfcuseradmin_mapper' => 'CdiUser\Mapper\UserZendDb',
    )
);
