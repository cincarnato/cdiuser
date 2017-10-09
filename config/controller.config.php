<?php

return array(
    'factories' => array(
        'cdiuseradmin' => \CdiUser\Factory\Controller\UserAdminControllerFactory::class,
        'cdiuserimpersonate' => \CdiUser\Factory\Controller\ImpersonateControllerFactory::class,
        'cdiuserlog' => \CdiUser\Factory\Controller\UserLogControllerFactory::class,
        'cdiuserlogdetail' => \CdiUser\Factory\Controller\UserLogDetailControllerFactory::class,
        'cdiuser' => \CdiUser\Factory\Controller\UserControllerFactory::class,
        'cditeam' => \CdiUser\Factory\Controller\TeamControllerFactory::class,
        'cditeamusers' => \CdiUser\Factory\Controller\TeamUsersControllerFactory::class,
        'cdiuserteams' => \CdiUser\Factory\Controller\UserTeamsControllerFactory::class,
    )
);

