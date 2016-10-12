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
    'zfc_rbac' => [
        'protection_policy' => GuardInterface::POLICY_DENY,
        'role_provider' => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'class_name' => 'CdiUser\Entity\Role',
                'role_name_property' => 'name'
            ]
        ],
        'guards' => [
            //Gestion por rutas: ruta (admite wilcard *) => role (admite wilcard *)
            'ZfcRbac\Guard\RouteGuard' => [
                'admin*' => ['admin'],
                'login' => ['guest'],
                'home' => ['*']
            ]
        ]
    ]
];
