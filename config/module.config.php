<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

$setting = array(
    'zfcuser' => require __DIR__ . '/zfcuser.config.php',
    'zfc_rbac' => require __DIR__ . '/zfc_rbac.config.php',
    'cdiuser' => array(
        'impersonate_redirect_route' => "home",
        'un_impersonate_redirect_route' => "home",
        'store_user_as_object' => false,
        'user_mapper' => 'CdiUser\Mapper\UserDoctrine',
        'allow_password_change' => true,
        'create_user_auto_password' => false,
        'mail_from' => 'ci.sys.virtual@gmail.com',
        'mail_from_name' => 'SYS',
        'mail_template_password_recovery' => 'cdi-user/mail/password-recovery',
        'mail_template_password_send' => 'cdi-user/mail/password-send',
        'transport' => '\Zend\Mail\Transport\Sendmail',
        'transport_options' => [
        ] 
    ),
    'view_helpers' => array(
        'factories' => array(
            \CdiUser\View\Helper\Impersonate::class => \CdiUser\Factory\View\Helper\ImpersonateFactory::class,
        ),
        'aliases' => [
            'isImpersonate' => \CdiUser\View\Helper\Impersonate::class,
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
                    'impersonate' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/impersonate/:userId',
                            'defaults' => array(
                                'controller' => 'cdiuserimpersonate',
                                'action' => 'impersonateUser',
                            ),
                        ),
                    ),
                    'unimpersonate' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/unimpersonate',
                            'defaults' => array(
                                'controller' => 'cdiuserimpersonate',
                                'action' => 'unimpersonateUser',
                            ),
                        ),
                    ),
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
                    'presend' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/presend/:userId',
                            'defaults' => array(
                                'controller' => 'cdiuseradmin',
                                'action' => 'presend'
                            ),
                        ),
                    ),
                    'send' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/send/:userId',
                            'defaults' => array(
                                'controller' => 'cdiuseradmin',
                                'action' => 'send'
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
            'cdiuser_picture' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/picture',
                    'defaults' => array(
                        'controller' => 'cdiuser',
                        'action' => 'picture',
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
    'controller_plugins' => [
        'factories' => [
            \CdiUser\Controller\Plugin\CdiUserMail::class => \CdiUser\Factory\Controller\Plugin\CdiUserMailFactory::class,
        ],
        'aliases' => [
            'CdiUserMail' => \CdiUser\Controller\Plugin\CdiUserMail::class,
        ]
    ],
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
