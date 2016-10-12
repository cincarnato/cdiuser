<?php

return array(
    'cdiuser' => array(
        'user_mapper' => 'CdiUser\Mapper\UserDoctrine',
        'user_list_elements' => array(
            'Id' => 'id',
            'Name' => 'displayName',
            'Email' => 'email',
            'Rol' => 'role',
            'Tel' => 'tel'),
        'create_user_auto_password' => false,
        'create_form_elements' => array(
            'Name' => 'displayName',
        ),
        'edit_form_elements' => array(
            'Name' => 'displayName',
        ),
    ),
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
        'enable_registration' => true,
        'enable_username' => true,
        'auth_identity_fields' => array('email', 'username'),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'zfcuseradmin' => __DIR__ . '/../view',
            'cdiuser' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'cdiuseradmin' => 'CdiUser\Controller\UserAdminController',
        ),
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
);
