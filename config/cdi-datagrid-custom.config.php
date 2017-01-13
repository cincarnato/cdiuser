<?php

//AN EXAMPLE COLUMNS CONFIG

$config = [
    "cdiDataGridUser" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiUser\Entity\User",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "crudConfig" => [
            "enable" => true,
            "add" => [
                "enable" => true,
                "class" => " fa fa-plus",
                "value" => " Agregar",
                "action" => "href='/admin/user/create'"
            ],
            "edit" => [
                "enable" => true,
                "class" => " fa fa-pencil",
                "value" => "",
                "action" => "href='/admin/user/edit/{{id}}'"
            ],
            "del" => [
                "enable" => true,
                "class" => " fa fa-trash",
                "value" => "",
                "action" => "href='/admin/user/remove/{{id}}'"
            ],
            "view" => [
                "enable" => true,
                "class" => "fa fa-list",
                "value" => "",
            ]
        ],
        "columnsConfig" => array(
            "username" => [
                "displayName" => "usuario"
            ],
            "displayName" => [
                "displayName" => "nombre"
            ],
            "password" => [
                "hidden" => true
            ],
            "role" => [
                "type" => "relational",
                "orderProperty" => 'name'
            ],
            "tel" => [
                "hidden" => true
            ],
            "teams" => [
                "hidden" => true,
                "type" => "relational"
            ],
            "state" => [
                "type" => "boolean",
                "displayName" => "estado",
                "valueWhenTrue" => "Activo",
                "valueWhenFalse" => "Inactivo"
            ],
            "createdAt" => [
                "type" => "date",
                "displayName" => "creado",
                "format" => "Y-m-d H:i:s"
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "actualizado",
                "format" => "Y-m-d H:i:s"
            ],
        )
    ],
    "cdiDataGridUserLog" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiUser\Entity\UserLog",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "crudConfig" => [
            "enable" => true,
            "add" => [
                "enable" => false,
            ],
            "edit" => [
                "enable" => false,
            ],
            "del" => [
                "enable" => false,
            ],
            "view" => [
                "enable" => true,
                "class" => "fa fa-list cursor-pointer",
                "value" => "",
            ]
        ],
        "columnsConfig" => array(
            "id" => [
                "hidden" => true
            ],
            "user" => [
                "type" => "relational",
                "displayName" => "usuario"
            ],
            "agent" => [
                "hidden" => true
            ],
            "loginCount" => [
                "displayName" => "sesiones"
            ],
            "firstIp" => [
                "displayName" => "Primer IP"
            ],
            "lastIp" => [
                "displayName" => "Ultima IP"
            ],
            "sesionId" => [
                "hidden" => true
            ],
            "firstSesion" => [
                "type" => "date",
                "displayName" => "Primer Login",
                "format" => "Y-m-d H:i:s"
            ],
            "lastSesion" => [
                "type" => "date",
                "displayName" => "Ultimo Login",
                "format" => "Y-m-d H:i:s"
            ],
        )
    ],
    "cdiDataGridUserLogDetail" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiUser\Entity\UserLogDetail",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
        "crudConfig" => [
            "enable" => true,
            "add" => [
                "enable" => false,
            ],
            "edit" => [
                "enable" => false,
            ],
            "del" => [
                "enable" => false,
            ],
            "view" => [
                "enable" => true,
                "class" => "fa fa-list cursor-pointer",
                "value" => "",
            ]
        ],
        "columnsConfig" => array(
            "id" => [
                "hidden" => true
            ],
            "user" => [
                "type" => "relational",
                "displayName" => "usuario"
            ],
            "agent" => [
                "hidden" => true
            ],
            "sesionId" => [
                "hidden" => true
            ],
            "dateSesion" => [
                "type" => "date",
                "displayName" => "Fecha",
                "format" => "Y-m-d H:i:s"
            ],
            
        )
    ],
    "cdiDataGridTeam" => [
        "sourceConfig" => [
            "type" => "doctrine",
            "doctrineOptions" => [
                "entityName" => "\CdiUser\Entity\Team",
                "entityManager" => "Doctrine\ORM\EntityManager"
            ]
        ],
 
        "columnsConfig" => array(
            "name" => [
                "displayName" => "nombre"
            ],
            "users" => [
                "hidden" => true,
                "type" => "relational"
            ],
            "createdAt" => [
                "type" => "date",
                "displayName" => "creado",
                "format" => "Y-m-d H:i:s"
            ],
            "updatedAt" => [
                "type" => "date",
                "displayName" => "actualizado",
                "format" => "Y-m-d H:i:s"
            ],
        )
    ],
];

return $config;
