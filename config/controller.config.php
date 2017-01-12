<?php

return array(
    'factories' => array(
        'cdiuseradmin' => \CdiUser\Factory\Controller\UserAdminControllerFactory::class,
        'cdiuserlog' => \CdiUser\Factory\Controller\UserLogControllerFactory::class,
        'cdiuser' => \CdiUser\Factory\Controller\UserControllerFactory::class,
        'cdigroup' => \CdiUser\Factory\Controller\GroupControllerFactory::class,
        'cdigroupusers' => \CdiUser\Factory\Controller\GroupUsersControllerFactory::class,
    )
);

