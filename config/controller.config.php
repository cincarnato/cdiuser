<?php

return array(
            'factories' => array(
                'cdiuseradmin' =>  \CdiUser\Factory\Controller\UserAdminControllerFactory::class,
                   'cdiuserlog' =>  \CdiUser\Factory\Controller\UserLogControllerFactory::class,
                'cdiuser' =>  \CdiUser\Factory\Controller\UserControllerFactory::class
                
            )
        );

