<?php

/**
 * TITLE
 *
 * Description
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 *
 * @package Paquete
 */
use ZfcRbac\Guard\GuardInterface;

return [
    'protection_policy' => GuardInterface::POLICY_DENY,
    'role_provider' => [
        'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
            'object_manager' => 'doctrine.entitymanager.orm_default',
            'class_name' => 'CdiUser\Entity\Role',
            'role_name_property' => 'name'
        ]
    ],
    'guards' => [
        'ZfcRbac\Guard\RouteGuard' => [
            'cdiuser_lpass' => ['guest'],
            'cdiuser_log_in' => ['user'],
            'cdiuser_log_out' => ['guest'],
            'cdiuser_picture' => ['user'],
            'cdiuser_admin/unimpersonate' => ['user'],
            'cdiuser_admin*' => ['admin'],
            'zfcuser/login' => ['guest'],
            'zfcuser/register' => ['guest'], // required if registration is enabled
            'zfcuser*' => ['user'], // includes logout, changepassword and changeemail
            'home' => ['*']
        ]
    ],
    'guest_role' => 'guest',
    'unauthorized_strategy' => [
        'template' => 'error/403'
    ],
    'redirect_strategy' => [
        /**
         * Enable redirection when the user is connected
         */
        'redirect_when_connected' => true,
        /**
         * Set the route to redirect when user is connected (of course, it must exist!)
         */
        'redirect_to_route_connected' => 'home',
        /**
         * Set the route to redirect when user is disconnected (of course, it must exist!)
         */
        'redirect_to_route_disconnected' => 'zfcuser/login',
        /**
         * If a user is unauthorized and redirected to another route (login, for instance), should we
         * append the previous URI (the one that was unauthorized) in the query params?
         */
        'append_previous_uri' => true,
        /**
         * If append_previous_uri option is set to true, this option set the query key to use when
         * the previous uri is appended
         */
        'previous_uri_query_key' => 'redirect'
    ],
];
