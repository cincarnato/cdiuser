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
                "class" => "btn btn-primary fa fa-plus",
                "value" => " Agregar",
                "action" => "href='/admin/user/create'"
            ],
            "edit" => [
                "enable" => true,
                "class" => "btn btn-primary fa fa-edit",
                "value" => "",
                "action" => "href='/admin/user/edit/{{id}}'"
            ],
            "del" => [
                "enable" => true,
                "class" => "btn btn-danger fa fa-trash",
                "value" => "",
                "action" => "href='/admin/user/remove/{{id}}'"
            ],
            "view" => [
                "enable" => true,
                "class" => "btn btn-success fa fa-list",
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
];

return $config;
